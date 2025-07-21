<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Cheque;
use App\Models\Paiement;
use Illuminate\Http\Request;
use App\Models\TaxeEntreprise;
use App\Models\PaiementInitial;

use App\Http\Controllers\Controller;

class EspaceClientController extends Controller
{
    //
    public function index()
    {
        $us = auth()->user()->entreprise;
        $valeurs = TaxeEntreprise::where('entreprise_id', $us->id)
            ->where('status', 2) // a change apres
            ->get();
        $sommeMontants = TaxeEntreprise::where('entreprise_id', $us->id)
            ->where('status', 2) // a change apres
            ->sum('montant');
        // dd($us, $valeurs, $sommeMontants);
        $module = "Module Espace Clients  ";
        $action = "A consulter l'espace Client  ";
        Logs::saveLog($module, $action);
        return view('espaceClient.index', compact('us', 'valeurs', 'sommeMontants'));
    }

    public function pageEnregistCheque(Request $request)
    {
        $us = auth()->user()->entreprise;
        // dd($request->all());
        $id = $request->idtaxe;
        if (!empty($id)) {
            $valeur = TaxeEntreprise::findOrFail($id);
            $montant = $valeur->montant;
            // dd($valeur);
            $libelle = 'Paiement du : ' . $valeur->periode;
        } else {
            $montant = $request->montant;
            $valeur = [];
            $libelle = 'Paiement de tout les factures de l\'entreprise';
        }
        $module = "Module Espace Clients  ";
        $action = "A consulter la page d'enregistrement de cheque ou virement   ";
        Logs::saveLog($module, $action);
        return view('espaceClient.cheques.index', compact('us', 'valeur', 'montant', 'libelle'));
    }

    public function chequEnregistre(Request $request)
    {
        // dd($request->all());
        // Validation des données
        $request->validate([
            'montant' => 'required|numeric',
            'numero_cheque' => 'required|string|max:255',
            'banque' => 'required|string|max:255',
            'date_emission' => 'required|date',
            'titulaire' => 'required|string|max:255',
        ]);
        // Enregistrement du chèque
        $us = auth()->user()->entreprise;
        $cheque = new Cheque();
        $cheque->entreprise_id = $us->id;
        $cheque->taxe_entreprise_id = $request->idTaxe ?? null; // Si idtaxe est vide, on le met à null
        $cheque->montant = $request->montant;
        $cheque->numero_cheque = $request->numero_cheque;
        $cheque->banque = $request->banque;
        $cheque->autre_banque = $request->autre_banque ?? null; // Si autre_banque est vide, on le met à null
        $cheque->date_emission = $request->date_emission;
        $cheque->titulaire = $request->titulaire;
        $cheque->NaturePaiement = $request->NaturePaiement;
        $cheque->notes = $request->notes ?? null; // Si notes est vide, on le met à null
        $cheque->status = 2; // En attente
        $cheque->save();
        // Redirection avec un message de succès
        $module = "Module Espace Clients  ";
        $action = "A enregistrer un cheque ou virement  ";
        Logs::saveLog($module, $action);
        return redirect()->route('succesCheque', $cheque->id)->with('success', 'Chèque enregistré avec succès.');
    }

    public function succesEnregiCheque($id)
    {
        $cheque = Cheque::findOrFail($id);
        // dd($cheque);
        $module = "Module Espace Clients  ";
        $action = "A consulter la page de succes pour l'enregistrement d'un cheque ou virement  ";
        Logs::saveLog($module, $action);
        return view('espaceClient.cheques.succes', compact('cheque'));
        // return redirect()->route('espaceClient.index')->with('success', 'Chèque enregistré avec succès.');
    }

    public function mesrecus($id)
    {
        $paiements = PaiementInitial::where('entreprise_id', $id)
            // ->where('status', 1) // Paiements réussis
            // ->get();
            ->paginate(10);
        $cheques = Cheque::where('entreprise_id', $id)
            ->paginate(10);
        // dd($cheques);
        $module = "Module Espace Clients  ";
        $action = "A consulter la page de transation des paiements  ";
        Logs::saveLog($module, $action);
        return view('espaceClient.recupaiements', compact('paiements', 'cheques'));
    }

    public function editChequeOuVirement($id)
    {
        $cheque = Cheque::findOrFail($id);
        // dd($cheque);

          if (!empty($cheque->taxe_entreprise_id)) {
            $valeur = TaxeEntreprise::findOrFail($cheque->taxe_entreprise_id);
            $montant = $cheque->montant;
            // dd($valeur);
            $libelle = 'Paiement du : ' . $valeur->periode;
        } else {
            $montant = $cheque->montant;
            $valeur = [];
            $libelle = 'Paiement de tout les factures de l\'entreprise';
        }
        $module = "Module Espace Clients  ";
        $action = "A consulter la page de modification d'un cheque ou virement  ";
        Logs::saveLog($module, $action);

        return view('espaceClient.cheques.edit', compact('cheque','libelle','montant','valeur'));
    }

     public function chequEnregistreUdapte(Request $request , $id)
    {
        
        $request->validate([
            'montant' => 'required|numeric',
            'numero_cheque' => 'required|string|max:255',
            'banque' => 'required|string|max:255',
            'date_emission' => 'required|date',
            'titulaire' => 'required|string|max:255',
        ]);
        // Enregistrement du chèque
        $us = auth()->user()->entreprise;
        $cheque =  Cheque::findOrFail($id);
        $cheque->entreprise_id = $us->id;
        $cheque->taxe_entreprise_id = $request->idTaxe ?? null; // Si idtaxe est vide, on le met à null
        $cheque->montant = $request->montant;
        $cheque->numero_cheque = $request->numero_cheque;
        $cheque->banque = $request->banque;
        $cheque->autre_banque = $request->autre_banque ?? null; // Si autre_banque est vide, on le met à null
        $cheque->date_emission = $request->date_emission;
        $cheque->titulaire = $request->titulaire;
        $cheque->NaturePaiement = $request->NaturePaiement;
        $cheque->notes = $request->notes ?? null; // Si notes est vide, on le met à null
        $cheque->status = 2; // En attente
        $cheque->save();
        // Redirection avec un message de succès
        $module = "Module Espace Clients  ";
        $action = "A enregistrer un cheque ou virement  ";
        Logs::saveLog($module, $action);
        return redirect()->route('succesCheque', $cheque->id ?? $id)->with('success', 'Chèque enregistré avec succès.');
    }


}
