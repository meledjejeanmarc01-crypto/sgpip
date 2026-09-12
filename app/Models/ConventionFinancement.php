<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConventionFinancement extends Model
{
    protected $table = 'conventions_financement';

    protected $fillable = [
        'type_accord', 'nature_financement', 'date_limite_tirage',
        'niveau_avancement_negociations', 'numero_accord_signe',
        'montant', 'date_signature', 'financement_id',
    ];

    protected function casts(): array
    {
        return ['date_limite_tirage' => 'date', 'date_signature' => 'date', 'montant' => 'decimal:2'];
    }

    public function financement()
    {
        return $this->belongsTo(Financement::class);
    }
}
