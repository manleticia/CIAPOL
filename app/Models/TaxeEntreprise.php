<?php

namespace App\Models;
use App\Models\Cheque;
use App\Models\Paiement;
use App\Models\Entreprise;
use App\Models\Administrateur;
use App\Models\PaiementInitial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxeEntreprise extends Model
{
   use HasFactory, SoftDeletes, Notifiable;
    protected $guarded = [];

      public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }
       public function paiements(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }
      public function paiementInitiales(): HasOne
    {
        return $this->hasOne(PaiementInitial::class);
    }
        public function cheques(): HasOne
    {
        return $this->hasOne(Cheque::class);
    }
          public function administrateur(): BelongsTo
    {
        return $this->belongsTo(Administrateur::class);
    }
}
