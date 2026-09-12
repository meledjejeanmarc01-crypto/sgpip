<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Risque extends Model
{
    protected $fillable = ['libelle', 'consequence', 'probabilite', 'criticite', 'mesure_mitigation', 'type_strategie', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
