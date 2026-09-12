<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cible extends Model
{
    protected $fillable = ['type_beneficiaire', 'acteur', 'probleme_specifique', 'attentes', 'craintes', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
