<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Risque extends Model
{
    protected $fillable = ['libelle', 'consequence', 'probabilite', 'impact', 'mesure_mitigation', 'type_strategie', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    /** Projet auquel cet élément est rattaché. */
    public function projetAssocie(): ?Projet
    {
        return $this->projet;
    }
}
