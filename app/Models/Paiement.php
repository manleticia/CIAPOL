<?php

namespace App\Models;

use App\Models\Entreprise;
use App\Models\Administrateur;
use App\Models\TaxeEntreprise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{

    use HasFactory, SoftDeletes, Notifiable;
    protected $guarded = [];

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

}
