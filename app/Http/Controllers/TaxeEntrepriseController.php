<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Entreprise;
use App\Models\TaxeEntreprise;
use App\Http\Requests\StoreTaxeEntrepriseRequest;
use App\Http\Requests\UpdateTaxeEntrepriseRequest;

class TaxeEntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

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
    public function store(StoreTaxeEntrepriseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TaxeEntreprise $taxeEntreprise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaxeEntreprise $taxeEntreprise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaxeEntrepriseRequest $request, TaxeEntreprise $taxeEntreprise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaxeEntreprise $taxeEntreprise)
    {
        //
    }

    // les des taxes des entreprises d'une entreprise donnée7
    public function listeTaxeEntreprise($id)
    {
        $taxes = TaxeEntreprise::where('entreprise_id', $id)->get();
        $libelle = Entreprise::find($id)->raison_sociale;
        // dd($taxes ,$libelle);
        $module = " Module Taxe Entreprise";
        $action =  "A consulter la liste des taxes entreprises";
        Logs::saveLog($module, $action);
        return view('dashboards.entreprise.taxes.index', compact('taxes', 'libelle'));
    }
}
