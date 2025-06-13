<?php

namespace App\Models;
use App\Models\User;
use App\Models\Cheque;
use App\Models\Inscrit;
use App\Models\Paiement;
use App\Models\TaxeEntreprise;
use App\Models\PaiementInitial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entreprise extends Model
{
     use HasFactory, SoftDeletes, Notifiable;
    protected $guarded = [];

      public function taxeEntreprises(): HasOne
    {
        return $this->hasOne(TaxeEntreprise::class);
    }
      public function inscrits(): HasOne
    {
        return $this->hasOne(Inscrit::class);
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
      public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
