<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = [
        'projet_id',
        'montant_prevu',
        'exercice',
        'source_financement',
        'date',
        'observation',
    ];

    protected $casts = [
        'montant_prevu' => 'decimal:2',
        'date' => 'date',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }
}