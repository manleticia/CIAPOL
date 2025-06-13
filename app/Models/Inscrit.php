<?php

namespace App\Models;

use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscrit extends Model
{
     use HasFactory, SoftDeletes, Notifiable;
    protected $guarded = [];

      public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }
}
