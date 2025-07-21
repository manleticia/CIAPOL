<?php

namespace App\Models;

use App\Models\Entreprise;
use App\Models\Administrateur;
use App\Models\TaxeEntreprise;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaiementInitial extends Model
{
    use HasFactory, SoftDeletes, Notifiable;
    protected $guarded = [];

     protected $fillable = [
        'entreprise_id',
        'administrateur_id',
        'taxe_entreprise_id',
        'montant',
        'codePaiement',
        'referencePaiement',
        'moyenPaiement',
        'contactPaiement',
        'datePaiement',
        'HeurePaiement',
        'entite',
        'status',
        'message_retour',
        'payNature',
        'total_amount',
    ];

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }
    public function taxeEntreprise(): BelongsTo
    {
        return $this->belongsTo(TaxeEntreprise::class);
    }
    public function administrateur(): BelongsTo
    {
        return $this->belongsTo(Administrateur::class);
    }


    public function scopePercentageValidated($query)
    {
        $total = $query->count();
        $validated = $query->clone()->where('status', 1)->count();

        return $total > 0 ? round(($validated / $total) * 100, 2) : 0;
    }

    /**
     * Regroupement par méthode de paiement
     */
    public function scopeGroupByMethod($query)
    {
        return $query->select([
            'moyenPaiement',
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(montant) as montant')
        ])
            ->groupBy('moyenPaiement')
            ->orderByDesc('montant');
    }

    /**
     * Filtre pour le mois en cours
     */
    public function scopeThisMonth($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ]);
    }

    /**
     * Somme journalière des paiements
     */
    public function scopeDailySum($query)
    {
        return $query->selectRaw('DATE(created_at) as date, SUM(montant) as total')
            ->groupBy('date')
            ->orderBy('date');
    }

    /**
     * Regroupement par type de taxe
     */
    public function scopeGroupByTaxe($query)
    {
        return $query->select([
            'taxe_entreprise_id',
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(montant) as montant')
        ])
            ->groupBy('taxe_entreprise_id')
            ->orderByDesc('montant');
    }

    /**
     * Top entreprises payeuses
     */
    public function scopeTopCompanies($query, $limit = 5)
    {
        return $query->select([
            'entreprise_id',
            DB::raw('COUNT(*) as payment_count'),
            DB::raw('SUM(montant) as montant')
        ])
            ->groupBy('entreprise_id')
            ->orderByDesc('montant')
            ->limit($limit);
    }

    /**
     * Paiements groupés par heure pour aujourd'hui
     */
    public function scopeTodayByHour($query)
    {
        return $query->whereDate('created_at', today())
            ->selectRaw('HOUR(created_at) as hour, SUM(montant) as amount')
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('amount', 'hour');
    }



    public function scopeMonthlySum($query)
{
    return $query->selectRaw('YEAR(datePaiement) as annee,
                            MONTH(datePaiement) as mois,
                            SUM(CAST(montant AS DECIMAL(10,2))) as montant')
                ->groupBy('annee', 'mois')
                ->orderBy('annee')
                ->orderBy('mois');
}

// 2. Version alternative avec noms de mois
public function scopeMonthlySumWithName($query)
{
    return $query->selectRaw('YEAR(datePaiement) as annee,
                            MONTH(datePaiement) as mois,
                            MONTHNAME(datePaiement) as nom_mois,
                            SUM(CAST(montant AS DECIMAL(10,2))) as montant')
                ->groupBy('annee', 'mois', 'nom_mois')
                ->orderBy('annee')
                ->orderBy('mois');
}
}
