<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use App\Models\PaiementInitial;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $paiImpay = PaiementInitial::where('status','3')->sum('montant');
        $paiValid = PaiementInitial::where('status','1')->sum('montant');
        $nbreEntre = Entreprise::count();
        $virement = Cheque::where('status',2)->count();
        // dd($paiValid);
        return view('dashboards.index',compact('paiImpay','paiValid','nbreEntre','virement'));
    }
    public function listeInscription()
    {
        return view('dashboards.inscription');
    }
    // entreprise
}
