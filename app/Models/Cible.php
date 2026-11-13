<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Volet de la fiche projet (canevas du Ministère) : table « cibles ».
class Cible extends Model
{
    protected $table = 'cibles';

    protected $fillable = ['type_beneficiaire', 'groupe_acteur', 'acteur', 'probleme_specifique', 'attentes', 'craintes', 'taille', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
