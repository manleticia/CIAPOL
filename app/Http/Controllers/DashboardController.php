<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Logs;
use App\Models\Cheque;
use App\Models\Entreprise;
use Illuminate\Http\Request;

use App\Models\PaiementInitial;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $paiImpay = PaiementInitial::where('status', '3')->sum('montant');
        $paiValid = PaiementInitial::where('status', '1')->sum('montant');
        // $paiements = PaiementInitial::where('status', '1')->get();
        $paiements = PaiementInitial::where('status', '1')
            ->whereDate('created_at', Carbon::today())
            ->get();
        $nbreEntre = Entreprise::count();
        $virement = Cheque::where('status', 2)->count();



        $today = now()->format('Y-m-d');
        $todayPayments = PaiementInitial::whereDate('created_at', $today)
            ->where('status', '1')->get();
        $growthRate = $this->calculateGrowthRate();
        $validatedPayments = PaiementInitial::where('status', 1)
            ->get();
        $validatedPercentage = PaiementInitial::whereDate('created_at', $today)->percentageValidated();
        $paymentMethods = PaiementInitial::whereDate('created_at', $today)->groupByMethod();
        // dd($paymentMethods);
        // $monthlyPayments = PaiementInitial::thisMonth()->dailySum();
        $monthlyPayments = PaiementInitial::selectRaw('
        YEAR(datePaiement) as year,
        MONTH(datePaiement) as month,
        MONTHNAME(datePaiement) as month_name,
        SUM(CAST(montant AS DECIMAL(10,2))) as montant
        ')
            ->groupBy('year', 'month', 'month_name')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // $taxesDistribution = PaiementInitial::with('taxe_entreprise')->whereDate('created_at', $today)->groupByTaxe();

        $taxesDistribution = PaiementInitial::with('taxeEntreprise')
            ->whereDate('datePaiement', $today)
            ->groupByTaxe()
            ->get()
            ->map(function ($item) {
                return [
                    'taxe' => $item->taxeEntreprise,
                    'count' => $item->count,
                    'total' => $item->montant // Utilisation du bon nom de colonne
                ];
            });

        $topCompanies = PaiementInitial::with('entreprise')->whereDate('created_at', $today)->topCompanies(5);
        // dd($topCompanies);
        $todayPaymentsByHour = PaiementInitial::todayByHour();

        $module = "Module Tableau de bord ";
        $action = "A consulter le tableau de bord administrateur";
        Logs::saveLog($module, $action);
        return view('dashboards.index', compact('paiImpay', 'paiValid', 'nbreEntre', 'virement', 'paiements', 'todayPayments', 'growthRate', 'validatedPayments', 'validatedPercentage', 'paymentMethods', 'monthlyPayments', 'taxesDistribution', 'topCompanies', 'todayPaymentsByHour', 'today'));
    }
    public function listeInscription()
    {
        $module = "Module Tableau de bord ";
        $action = "A consulter la listes des inscrits";
        Logs::saveLog($module, $action);
        return view('dashboards.inscription');
    }
    // entreprise

    private function calculateGrowthRate(): float
    {
        // Récupérer la somme des paiements d'aujourd'hui
        $todayAmount = PaiementInitial::whereDate('created_at', now()->format('Y-m-d'))
            ->sum('montant');

        // Récupérer la somme des paiements d'hier
        $yesterdayAmount = PaiementInitial::whereDate('created_at', now()->subDay()->format('Y-m-d'))
            ->sum('montant');

        // Éviter la division par zéro
        if ($yesterdayAmount == 0) {
            return $todayAmount > 0 ? 100.0 : 0.0;
        }

        // Calculer le taux de croissance en pourcentage
        $growthRate = (($todayAmount - $yesterdayAmount) / $yesterdayAmount) * 100;

        // Arrondir à 2 décimales
        return round($growthRate, 2);
    }




    public function getPaymentStats($period)
    {
        $query = PaiementInitial::where('status', 1);

        switch ($period) {
            case 'day':
                $query->whereDate('created_at', Carbon::today());
                $categories = range(0, 23); // heures
                break;
            case 'week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                $categories = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
                break;
            case 'month':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                $categories = range(1, now()->daysInMonth); // jours du mois
                break;
            case 'year':
                $query->whereYear('created_at', now()->year);
                $categories = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
                break;
            default:
                return response()->json([
                    'success' => false,
                    'error' => 'Période invalide.'
                ]);
        }

        // Simuler des montants pour l'exemple
        $series = array_fill(0, count($categories), 0);
        foreach ($query->get() as $paiement) {
            switch ($period) {
                case 'day':
                    $index = (int)Carbon::parse($paiement->created_at)->format('H');
                    break;
                case 'week':
                    $index = Carbon::parse($paiement->created_at)->dayOfWeekIso - 1;
                    break;
                case 'month':
                    $index = Carbon::parse($paiement->created_at)->day - 1;
                    break;
                case 'year':
                    $index = Carbon::parse($paiement->created_at)->month - 1;
                    break;
            }
            $series[$index] += $paiement->montant ?? 0;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories,
                'series' => $series
            ]
        ]);
    }
}
