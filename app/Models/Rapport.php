<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    protected $fillable = ['type', 'titre', 'periode', 'donnees', 'fichier', 'date', 'projet_id', 'utilisateur_id'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    /** Projet auquel cet élément est rattaché. */
    public function projetAssocie(): ?Projet
    {
        return $this->projet;
    }
}
