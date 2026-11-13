<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financement extends Model
{
    protected $fillable = [
        'montant_engage', 'date', 'reference', 'type_source', 'numero_convention', 'date_convention', 'devise', 'taux_change',
        'ressources_internes', 'ressources_externes', 'statut', 'observation',
        'code_guichet', 'montant_devise', 'beneficiaire', 'montant_don', 'montant_emprunt',
        'projet_id', 'bailleur_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date', 'date_convention' => 'date',
            'taux_change' => 'decimal:4',
            'ressources_internes' => 'decimal:2',
            'ressources_externes' => 'decimal:2',
            'montant_devise' => 'decimal:2',
            'montant_don' => 'decimal:2',
            'montant_emprunt' => 'decimal:2',
        ];
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function bailleur()
    {
        return $this->belongsTo(Bailleur::class);
    }

    public function decaissements()
    {
        return $this->hasMany(Decaissement::class);
    }

    public function conventionFinancement()
    {
        return $this->hasOne(ConventionFinancement::class);
    }

    public function getSourceLibelleAttribute(): string
    {
        return $this->bailleur?->nom ?? '—';
    }

    /** Projet auquel cet élément est rattaché. */
    public function projetAssocie(): ?Projet
    {
        return $this->projet;
    }
}
