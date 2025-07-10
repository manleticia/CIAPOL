<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Logs;
use App\Models\Cheque;
use App\Models\Paiement;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use App\Models\TaxeEntreprise;
use App\Models\PaiementInitial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StoreChequeRequest;

use App\Http\Requests\UpdateChequeRequest;

class ChequeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //7
        $cheques = Cheque::all();
        $module = "Module Cheque ";
        $action = "A  consulter la liste des cheques ou Virements";
        Logs::saveLog($module, $action);
        return view('dashboards.cheques.index', compact('cheques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $entreprises = Entreprise::All();
        // dd($entreprises);
        $module = "Module Cheque ";
        $action = "A  consulter la page enregistrement des cheques ou virements ";
        Logs::saveLog($module, $action);
        return view('dashboards.cheques.create', compact('entreprises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChequeRequest $request)
    {
        //
        // dd($request->all());
        try {
            DB::beginTransaction();
            $idTaxe = '';
            if ($request->taxe_entreprise == '00') {
                $idTaxe = null;
            } else {
                $idTaxe = $request->taxe_entreprise;
            }
            $montant = extraireMontantEntier($request->montant);
            $idAdmin = Auth::user()->administrateur->id;

            $cheque = new Cheque();
            $cheque->entreprise_id = $request->entreprise_id;
            $cheque->taxe_entreprise_id = $idTaxe ?? null; // Si idtaxe est vide, on le met à null
            $cheque->montant = $montant;
            $cheque->numero_cheque = $request->numero_cheque;
            $cheque->banque = $request->banque;
            $cheque->autre_banque = $request->autre_banque ?? null; // Si autre_banque est vide, on le met à null
            $cheque->date_emission = $request->date_emission;
            $cheque->titulaire = $request->titulaire;
            $cheque->NaturePaiement = $request->NaturePaiement;
            $cheque->notes = $request->notes ?? null; // Si notes est vide, on le met à null
            $cheque->status = 2; // En attente
            $cheque->save();
            $module = "Module Cheque ";
            $action = "l'administrateur avec l'id : $idAdmin viens d'enregistre un $request->NaturePaiement  ayant l'identifiant :$cheque->id";
            Logs::saveLog($module, $action);
            DB::commit();
            return redirect()->route('listCheques')->with('success', ' Virement ou Chéque  enregistre  avec succès');
            //code...
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Erreur lors de l'enregistrement du chèque ou virement : " . $e->getMessage());
            $module = "Module Cheque  ";
            $action = "Erreur lors de l'enregistrement  du chèque ou virement  : " . $e->getMessage();
            Logs::saveLog($module, $action);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement du chèque ou virement: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $cheque = Cheque::find($id);
        // dd($cheque);
        $module = "Module Cheque ";
        $action = "A  consulter la page detaitl d'un  cheque ayant id = $id";
        Logs::saveLog($module, $action);
        return view('dashboards.cheques.show', compact('cheque'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cheque $cheque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChequeRequest $request, Cheque $cheque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cheque $cheque)
    {
        //
    }
    // confirmation de cheque
    public function confirmeCheque($id)
    {

        try {
            DB::beginTransaction();
            $cheque = Cheque::findOrFail($id);
            $entreprise = Entreprise::find($cheque->entreprise_id);
            $email = $entreprise->user->email;
            // dd($cheque);

            $cheque->status = 1;
            $cheque->administrateur_id = Auth::user()->administrateur->id;
            $cheque->save();
            $module = "Module Cheque ";
            $action = "A valide le cheque ayant l'id = $id";
            Logs::saveLog($module, $action);
            // Enregistrement dans la table paiement initial
            $codePaiement = genereCodePaiement();
            $lieu = $cheque->autre_banque ?? $cheque->banque;

            $libelle = $cheque->taxe_entreprise_id
                ? "Paiement par cheque du : " . $cheque->taxeEntreprise->periode
                : "Paiement par cheque de Toutes les factures";

            // mise a jour des taxe Enteprise
            if (!empty($cheque->taxe_entreprise_id)) {
                $taxeEntreprise = TaxeEntreprise::where('id', $cheque->taxe_entreprise_id)->first();
                $taxeEntreprise->status = 1;
                $taxeEntreprise->administrateur_id = Auth::user()->administrateur->id;
                $taxeEntreprise->save();
            } else {
                $taxeEt = TaxeEntreprise::where('entreprise_id', $cheque->entreprise_id)
                    ->where('status', 2)
                    ->get();
                foreach ($taxeEt as $taxe) {
                    $taxe->status = 1;
                    $taxe->administrateur_id = Auth::user()->administrateur->id;
                    $taxe->save();
                }
            }
            $paiementInitiale = new PaiementInitial([
                'administrateur_id' => Auth::user()->administrateur->id,
                'entreprise_id' => $cheque->entreprise_id,
                'taxe_entreprise_id' => $cheque->taxe_entreprise_id,
                'montant' => $cheque->montant,
                'referencePaiement' => $cheque->numero_cheque,
                'codePaiement' => $codePaiement,
                'moyenPaiement' => $cheque->NaturePaiement,
                'contactPaiement' => "",
                'datePaiement' => $cheque->date_emission,
                'HeurePaiement' => Carbon::now(),
                // 'HeurePaiement' => Carbon::now()->toTimeString(),
                'entite' => $libelle,
                'payNature' => 2,
                'message_retour' => "Paiement effectué avec succès",
                'status' => 1
            ]);
            $paiementInitiale->save();


            // Enregistrement dans la table paiement
            $paiement = new Paiement([
                'entreprise_id' => $paiementInitiale->entreprise_id,
                'taxe_entreprise_id' => $paiementInitiale->taxe_entreprise_id,
                'montant' => $paiementInitiale->montant,
                'referencePaiement' => $paiementInitiale->referencePaiement,
                'codePaiement' => $paiementInitiale->codePaiement,
                'moyenPaiement' => $paiementInitiale->moyenPaiement,
                'contactPaiement' => $paiementInitiale->contactPaiement,
                'datePaiement' => $paiementInitiale->datePaiement,
                'HeurePaiement' => $paiementInitiale->HeurePaiement,
                'entite' => $paiementInitiale->entite,
                'payNature' => $paiementInitiale->payNature,
                'message_retour' => $paiementInitiale->message_retour,
                'administrateur_id' => Auth::user()->administrateur->id,
                'status' => 1
            ]);
            $paiement->save();

            $montant = $paiementInitiale->montant;
            $lien_plateforme = urlSite();
            $nom_plateforme = "CIAPOL FACTURE";
            $telephone_support = "(+225) 2722421619";


            /// envoyer de mail a clients
            $sujet = "Confirmation de réception de paiement";
            $message = "
                <p>Cher(e) " . $entreprise->raison_sociale . ",</p>

                <p>Nous vous informons que nous avons bien reçu votre paiement par " . ($paiementInitiale->moyenPaiement == 'VIREMENT' ? 'virement' : 'chèque') . ".</p>

                <p><strong>Détails de la transaction :</strong></p>
                <ul>
                    <li>Montant reçu : " . $montant . " F CFA</li>
                    <li>Date de réception : " . date('d/m/Y') . "</li>
                    <li>Référence : " . $cheque->numero_cheque . "</li>
                </ul>

                <p>Votre compte a été crédité et vous pouvez maintenant accéder à l'ensemble des fonctionnalités de notre plateforme.</p>

                <div style='text-align:center; margin:20px 0;'>
                    <a href='" . $lien_plateforme . "' style='background-color:#007bff; color:white; padding:12px 24px; text-decoration:none; border-radius:5px; font-weight:bold;'>
                        Accéder à la plateforme
                    </a>
                </div>

                <p>Pour toute question concernant cette transaction, n'hésitez pas à répondre à cet email ou à nous contacter au " . $telephone_support . ".</p>

                <p>Cordialement,<br>
                L'équipe " . $nom_plateforme . "</p>
            ";

            $url = appelApiEmail();
            $template = View::make('email.index', ['contenumess' => $message])->render();
            $data = [
                'provider' => 'CIAPOL <info@mail-taseti.com>',
                "key_rsa" => 're_2i7H3Ynf_KRVm9VwTsrwrfF8isCBYvyyE',
                "destination" => $email,
                "sujet" => $sujet,
                "message" => $template
            ];

            $retourAPI = Http::post($url, $data);
            $res = $retourAPI->json();

            if ($retourAPI->status() == 200) {
                (int)$code = $res['status'];
                if ($code != 200) {
                    $message = "Une erreur s'est produite " . $code . ", DETAIL: " . messageBrut($res['message']) . " ERR: Inscritpion";
                    // Log::ajoutLOG($message);
                    $module = "Envoyer de Mail validation cheque Entreprise ";
                    $action = "Echec d'envoyer de mail  : $message";
                    Logs::saveLog($module, $action);
                } else {
                    DB::commit();
                    $module = "Envoyer de Mail  validation cheque client Entreprise";
                    $action = "Email envoyer avec success   : $entreprise->raison_sociale sur son email  $email ";
                    Logs::saveLog($module, $action);
                }
            } else {
                Log::error("Erreur lors de l'envoi de l'email. Statut API : " . $retourAPI->status());
            }


            $module = "Module Cheque Paiement ";
            $action = "A valide le cheque ayant l'id = $id donc valide le paiement $paiement->id ";
            Logs::saveLog($module, $action);

            return redirect()->route('listCheques')->with('success', 'Chèque validé avec succès');
        } catch (\Exception $e) {
            DB::rollBack();

            // Journaliser l'erreur pour le débogage
            Log::error("Erreur lors de la confirmation du chèque : " . $e->getMessage());
            $module = "Module Cheque  ";
            $action = "Erreur lors de la confirmation du chèque : " . $e->getMessage();
            Logs::saveLog($module, $action);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la validation du chèque: ' . $e->getMessage());
        }
    }

    // refuse de cheques
    public function refuseCheque(Request $request, $id)
    {
        $cheque = Cheque::find($id);
        $entreprise = Entreprise::find($cheque->entreprise_id);
        $email = $entreprise->user->email;
        $cheque->motif_rejet = $request->motif_rejet;
        $cheque->administrateur_id = Auth::user()->administrateur->id;
        $cheque->status = 3;
        $cheque->save();


        $montant = $cheque->montant;
        $lien_plateforme = urlSite();
        $nom_plateforme = "CIAPOL FACTURE";
        $telephone_support = "(+225) 2722421619";


        /// envoyer de mail a clients
        $sujet = "Refus  de réception de paiement";
        $message = "
                <p>Cher(e) " . $entreprise->raison_sociale . ",</p>

                <p>Nous vous informons que votre paiement par " . ($cheque->NaturePaiement == 'VIREMENT' ? 'virement' : 'chèque') . " à ete refuse.</p>

                <p><strong>Détails de la transaction :</strong></p>
                <ul>
                    <li>Montant reçu : " . $montant . " F CFA</li>
                    <li>Date de réception : " . date('d/m/Y') . "</li>
                    <li>Référence : " . $cheque->numero_cheque . "</li>
                    <li>Motif de refus : " . $cheque->motif_rejet . "</li>
                </ul>

                <p>Votre compte a été crédité et vous pouvez maintenant accéder à l'ensemble des fonctionnalités de notre plateforme.</p>

                <div style='text-align:center; margin:20px 0;'>
                    <a href='" . $lien_plateforme . "' style='background-color:#007bff; color:white; padding:12px 24px; text-decoration:none; border-radius:5px; font-weight:bold;'>
                        Accéder à la plateforme
                    </a>
                </div>

                <p>Pour toute question concernant cette transaction, n'hésitez pas à répondre à cet email ou à nous contacter au " . $telephone_support . ".</p>

                <p>Cordialement,<br>
                L'équipe " . $nom_plateforme . "</p>
            ";

        $url = appelApiEmail();
        $template = View::make('email.index', ['contenumess' => $message])->render();
        $data = [
            'provider' => 'CIAPOL <info@mail-taseti.com>',
            "key_rsa" => 're_2i7H3Ynf_KRVm9VwTsrwrfF8isCBYvyyE',
            "destination" => $email,
            "sujet" => $sujet,
            "message" => $template
        ];

        $retourAPI = Http::post($url, $data);
        $res = $retourAPI->json();

        if ($retourAPI->status() == 200) {
            (int)$code = $res['status'];
            if ($code != 200) {
                $message = "Une erreur s'est produite " . $code . ", DETAIL: " . messageBrut($res['message']) . " ERR: Inscritpion";
                // Log::ajoutLOG($message);
                $module = "Envoyer de Mail refus cheque Entreprise ";
                $action = "Echec d'envoyer de mail  : $message";
                Logs::saveLog($module, $action);
            } else {
                DB::commit();
                $module = "Envoyer de Mail  refus cheque client Entreprise";
                $action = "Email envoyer avec success   : $entreprise->raison_sociale sur son email  $email ";
                Logs::saveLog($module, $action);
            }
        } else {
            Log::error("Erreur lors de l'envoi de l'email. Statut API : " . $retourAPI->status());
        }

        $module = "Module Cheque Paiement";
        $action = "A refuse le cheque ayant l'id = $id";
        Logs::saveLog($module, $action);
        return redirect()->route('listCheques')->with('success', 'Chèque refuse avec succès');
    }
}
