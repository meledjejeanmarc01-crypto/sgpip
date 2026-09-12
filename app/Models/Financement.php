<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financement extends Model
{
    protected $fillable = ['montant_engage', 'date', 'reference', 'projet_id', 'bailleur_id', 'etat_id'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function bailleur()
    {
        return $this->belongsTo(Bailleur::class);
    }

    public function etat()
    {
        return $this->belongsTo(Etat::class);
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
        if ($this->bailleur_id) {
            return $this->bailleur?->nom ?? '—';
        }
        return $this->etat?->libelle ?? 'État';
    }
}
