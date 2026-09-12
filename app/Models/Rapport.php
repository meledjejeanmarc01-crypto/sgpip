<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    protected $fillable = ['type', 'titre', 'donnees', 'fichier', 'date', 'projet_id', 'utilisateur_id'];

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
}
