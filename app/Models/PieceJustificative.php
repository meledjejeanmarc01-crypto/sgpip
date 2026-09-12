<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieceJustificative extends Model
{
    protected $table = 'pieces_justificatives';
    protected $fillable = ['fichier', 'categorie', 'libelle', 'projet_id', 'utilisateur_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}
