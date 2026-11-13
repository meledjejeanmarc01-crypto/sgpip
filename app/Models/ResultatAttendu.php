<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultatAttendu extends Model
{
    protected $table = 'resultats_attendus';

    protected $fillable = ['niveau', 'produit', 'libelle', 'situation_reference', 'cible', 'valeur_realisee', 'reste_a_atteindre', 'commentaire', 'objectif_specifique_id'];

    // RG30 : un résultat attendu est rattaché à un seul objectif spécifique.
    public function objectifSpecifique(): BelongsTo
    {
        return $this->belongsTo(ObjectifSpecifique::class);
    }

    /** Projet dont dépend ce résultat attendu (via son objectif spécifique). */
    public function projetAssocie(): ?Projet
    {
        return $this->objectifSpecifique?->projet;
    }
}
