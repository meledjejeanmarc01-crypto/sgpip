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
        'engagement_contractuel', 'date_avancement_negociations', 'proroge', 'duree_prorogation_mois',
    ];

    protected function casts(): array
    {
        return [
            'date_limite_tirage' => 'date', 'date_signature' => 'date', 'date_avancement_negociations' => 'date',
            'montant' => 'decimal:2', 'engagement_contractuel' => 'boolean', 'proroge' => 'boolean',
        ];
    }

    public function financement()
    {
        return $this->belongsTo(Financement::class);
    }

    /** Projet financé (via le financement concerné). */
    public function projetAssocie(): ?Projet
    {
        return $this->financement?->projet;
    }
}
