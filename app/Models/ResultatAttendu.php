<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultatAttendu extends Model
{
    protected $fillable = ['niveau', 'libelle', 'situation_reference', 'cible', 'valeur_realisee', 'reste_a_atteindre', 'commentaire', 'objectif_id'];

    public function objectif()
    {
        return $this->belongsTo(Objectif::class);
    }
}
