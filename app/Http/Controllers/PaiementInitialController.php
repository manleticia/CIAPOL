<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Paiement;
use Illuminate\Http\Request;
use App\Models\TaxeEntreprise;
use App\Models\PaiementInitial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Http;
use App\Http\Requests\StorePaiementInitialRequest;
use App\Http\Requests\UpdatePaiementInitialRequest;

class PaiementInitialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // liste de paiements
        $paiements = PaiementInitial::where('status', 1)
            ->get();
        $title = ' Liste des paiements effectués';
        // dd($paiements);
        $module = "Module Paiement  ";
        $action = "A consulter la listes de paiements";
        Logs::saveLog($module, $action);
        return view('dashboards.paiements.index', compact('paiements', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaiementInitialRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaiementInitial $paiementInitial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaiementInitial $paiementInitial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaiementInitialRequest $request, PaiementInitial $paiementInitial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaiementInitial $paiementInitial)
    {
        //
    }



    // enregistrement des paiements pour aller sur le hub de paiement
    public function paiementHub(Request $request)
    {
        $us = auth()->user()->entreprise;
        // dd($request->all(), $us, $us->user->email);
        try {
            DB::beginTransaction();
            $montant = 0;
            $libelle = "";
            if ($request->idtaxe) {
                $installation = TaxeEntreprise::findOrFail($request->idtaxe);
                $libelle = "Paiement de la facture  : $installation->periode  de l'entreprise  $us->raison_sociale ";
                // $libelle = $installation->numero_titre_facture;
                $montant = $request->montant ?? $installation->montant;
            } else {
                $libelle = "Paiement Total des Facture de l'entreprise : $us->raison_sociale";
                $montant = $request->montant;
            }
            $codePaiement = $this->genereCodePaiement();

            $paiementenattente = new PaiementInitial();
            $paiementenattente->montant = $montant;
            $paiementenattente->codePaiement = $codePaiement;
            $paiementenattente->entite = $libelle;
            $paiementenattente->entreprise_id = $us->id;
            $paiementenattente->taxe_entreprise_id = $request->idtaxe;
            $paiementenattente->status = 2;
            $paiementenattente->payNature = 2; // aller sur le hub de paiement
            $paiementenattente->save();
            DB::commit();
            $data = [
                'code_paiement' => $codePaiement,
                // 'credential_id' => "llnal6ched", // code unique donnee pour mes acces a la plateforme
                'nom_usager' =>  $us->raison_sociale ?? "xxxxxxxxxx",
                'prenom_usager' => $us->raison_sociale ?? "xxxxxxxxxx ",
                'telephone' =>  $us->telephone,
                'email' => $us->user->email ?? "xxxxxxxxxx",
                'libelle_article' => $libelle,
                'quantite' => 1,
                'montant' => $montant,
                'lib_order' => $libelle,
                // 'Url_Logo' =>  $logo,
                'Url_Logo' =>  asset('photos/pci.png'),
                'pay_fees' => 1,
                // 'Url_Retour' => route('passageCodeRetourHub',['codePaiement'=>$codePaiement]),
                // 'Url_Callback' => route('paiement_retour'),

                'Url_Retour' => 'https://127.0.0.1:8000/retourPaiementResultat/' . $codePaiement,
                'Url_Callback' => 'https://127.0.0.1:8000/api/Callback',
                // 'Url_Retour' => 'https://www.mafacture.ciapol-ci.com/retourPaiementResultat/' . $codePaiement,
                // 'Url_Callback' => 'https://www.mafacture.ciapol-ci.com/api/Callback',
            ];
            // dd($data);
            $reponse = Http::withHeaders(['MerchantId' => MerchantId(), 'ApiKey' => ApiKey()])
                ->post(lienApi(), $data);
            $ResJSON = $reponse->json();
            // dd($data, $ResJSON, $reponse);
            if ($reponse->status() === 200) {
                if ($ResJSON['code'] === 200) {
                    // Redirection sur le hub de paiement
                    if (!empty($ResJSON['url'])) {
                        $module = "Module Paiement  ";
                        $action = "A consulter le hub de paiement ";
                        Logs::saveLog($module, $action);
                        return redirect()->away($ResJSON['url']);
                    } else {
                        $mess = "Echec d'authentification pour acceder à la page demandée !";
                        // toas($mess,'success');
                        $code = $ResJSON['code'];
                        return view('dashboards.errors.index', compact('code', 'mess'));
                    }
                } else {
                    $mess = $ResJSON['message'];

                    $code = $ResJSON['code'];
                    return view('dashboards.errors.index', compact('code', 'mess'));
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la génération du code de paiement : ' . $e->getMessage());
            $module = "Module Paiement  ";
            $mess = 'Erreur lors de la génération du code de paiement : ' . $e->getMessage();
            $action = $mess;
            Logs::saveLog($module, $action);
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }
        // return view('paiement.hub');
    }
    private function genereCodePaiement($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $maxAttempts = 10; // Nombre maximal de tentatives pour générer un code unique
        $attempt = 0;

        do {
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            // Vérifier si le code généré existe déjà en base de données
            $existingCode = PaiementInitial::where('codePaiement', $randomString)->exists();

            $attempt++;

            if ($attempt > $maxAttempts) {
                throw new \Exception("Impossible de générer un code unique après $maxAttempts tentatives.");
            }
        } while ($existingCode);

        return $randomString;
    }


    /// api callback
    public function callbackFunction(Request $request)
    {
        // $log = new Log();
        (string) $RetourPaiementEnJSON = json_encode($request->input());
        (string) $Chaine = "Debut callback paiement, recu: " . $RetourPaiementEnJSON;
        try {
            (int) $Code = $request->code;
            (int) $Montant = $request->montant;
            (string) $codePaiement = $request->codePaiement;

            // Recupère le paiement en attente avec le statut '2'
            $paiementinit = PaiementInitial::where('codePaiement', $codePaiement)
                ->where('status', 2)
                ->first();

            if (!empty($paiementinit->id)) {
                if ($Code == 200) {
                    $paiement = new Paiement();

                    $paiement->taxe_entreprise_id = $paiementinit->taxe_entreprise_id;
                    $paiement->entreprise_id = $paiementinit->entreprise_id;
                    $paiement->montant = $Montant;
                    $paiement->codePaiement = $codePaiement;
                    $paiement->payNature = $paiementinit->payNature;
                    $paiement->entite = $paiementinit->entite;
                    // venant du hub
                    $paiement->referencePaiement = $request->referencePaiement;
                    $paiement->moyenPaiement = $request->moyenPaiement;
                    $paiement->datePaiement = $request->datePaiement;
                    $paiement->HeurePaiement =  $request->HeurePaiement;
                    $paiement->contactPaiement =  $request->numTel;
                    $paiement->message_retour =  "Paiement effectué avec succès";
                    $paiement->status =  ($Code == 200 ? 1 : 2);
                    $paiement->save();

                    $paiementinit->referencePaiement = $request->referencePaiement;
                    $paiementinit->moyenPaiement = $request->moyenPaiement;
                    $paiementinit->datePaiement = $request->datePaiement;
                    $paiementinit->HeurePaiement =  $request->HeurePaiement;
                    $paiementinit->contactPaiement =  $request->numTel;
                    $paiementinit->message_retour =  "Paiement effectué avec succès";
                    $paiementinit->status =  ($Code == 200 ? 1 : 2);


                    /// mise des tableaux
                    if (empty($paiementinit->taxe_entreprise_id)) {
                        $listes = TaxeEntreprise::where('entreprise_id', $paiementinit->entreprise_id)->get();
                        foreach ($listes as $liste) {
                            $liste->statut = 1; // Statut 1 pour indiquer que le paiement a été effectué
                            $liste->save();
                        }
                    } else {
                        $installationFinale = TaxeEntreprise::where('id', $paiementinit->taxe_entreprise_id)->first();
                        $installationFinale->statut = 1; // Statut 1 pour indiquer que le paiement a été effectué
                        $installationFinale->save();
                    }
                    $module = " Module Paiement";
                    $action = 'a Effectuer un paiement succes sur le hub : ';
                    Logs::saveLog($module, $action);
                } else {
                    // paiement echouer
                    $paiementinit->status = 3; //
                    $paiementinit->referencePaiement = $request->referencePaiement;
                    $paiementinit->message_retour =  "Echec du paiement";

                    $module = " Module Paiement";
                    $action = ' paiement echoue sur le hub : ';
                    Logs::saveLog($module, $action);
                }
                $paiementinit->save();
            } else {
                $Chaine .= "\n//// verification code paiement:#" . $codePaiement . "# introuvable ou déjà notifié dans 'paiement_en_attentes'";
                //       $log = new Logs();
                //     $log->id_concerne = $codePaiement;
                // $log->contenu = $Chaine;
                // $log->titre = "Log callback paiement";
                // $log->save();
                $module = " Module Paiement";
                $action =  $Chaine;
                Logs::saveLog($module, $action);
            }
        } catch (\Throwable $e) {
            $Chaine .= "\n/// Une erreur s'est produite. DETAIL_ERR: " . $e->getMessage();
            //    $log = new Logs();
            //           $log->id_concerne = "Erreur callback paiement";
            //     $log->contenu = $Chaine;
            //     $log->titre = "Log callback paiement";
            //     $log->save();
            $module = " Module Paiement";
            $action =  $Chaine;
            Logs::saveLog($module, $action);
        }

        return 'Ok';
    }
}
