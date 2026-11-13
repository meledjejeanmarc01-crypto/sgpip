<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acteur extends Model
{
    protected $fillable = ['libelle', 'role', 'groupe_acteur_id', 'partie_prenante_id'];

    // RG16 : un acteur appartient à une seule partie prenante.
    public function partiePrenante()
    {
        return $this->belongsTo(PartiePrenante::class);
    }

    public function groupeActeur()
    {
        return $this->belongsTo(GroupeActeur::class);
    }

    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'acteur_projet');
    }
}
