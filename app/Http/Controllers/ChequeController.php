<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cheque;
use App\Models\Paiement;
use Illuminate\Http\Request;
use App\Models\TaxeEntreprise;
use App\Models\PaiementInitial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        return view('dashboards.cheques.index', compact('cheques'));
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
    public function store(StoreChequeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $cheque = Cheque::find($id);
        // dd($cheque);

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
        DB::beginTransaction();

        try {
            $cheque = Cheque::findOrFail($id);
            $cheque->status = 1;
            $cheque->save();


            // Enregistrement dans la table paiement initial
            $codePaiement = genereCodePaiement();
            $lieu = $cheque->autre_banque ?? $cheque->banque;

            $libelle = $cheque->taxe_entreprise_id
                ? "Paiement par cheque du : " . $cheque->taxeEntreprise->semestre_depose
                : "Paiement par cheque de Toutes les factures";

            // mise a jour des taxe Enteprise
            if (!empty($cheque->taxe_entreprise_id)) {
                $taxeEntreprise = TaxeEntreprise::where('id', $cheque->taxe_entreprise_id)->first();
                $taxeEntreprise->status = 1;
                $taxeEntreprise->save();
            } else {
                $taxeEt = TaxeEntreprise::where('entreprise_id', $cheque->entreprise_id)
                    ->where('status', 2)
                    ->get();
                foreach ($taxeEt as $taxe) {
                    $taxe->status = 1;
                    $taxe->save();
                }
            }
            $paiementInitiale = new PaiementInitial([
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
                'status' => 1
            ]);
            $paiement->save();

            DB::commit();

            return redirect()->route('listCheques')->with('success', 'Chèque validé avec succès');
        } catch (\Exception $e) {
            DB::rollBack();

            // Journaliser l'erreur pour le débogage
            Log::error("Erreur lors de la confirmation du chèque : " . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la validation du chèque: ' . $e->getMessage());
        }
    }

    // refuse de cheques
    public function refuseCheque(Request $request, $id)
    {
        // dd($request->all(), $id);
        $cheque = Cheque::find($id);
        $cheque->motif_rejet = $request->motif_rejet;
        $cheque->status = 3;
        $cheque->save();
        return redirect()->route('listCheques')->with('success', 'Chèque refuse avec succès');
    }
}
