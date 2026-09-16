<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acteur extends Model
{
    protected $fillable = ['libelle', 'role', 'groupe_acteur_id'];

    public function groupeActeur()
    {
        return $this->belongsTo(GroupeActeur::class);
    }

    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'acteur_projet');
    }
}
