<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Feuille PROGRAMMATION, section 1 : table « demandes_financement ».
class DemandeFinancement extends Model
{
    protected $table = 'demandes_financement';

    protected $fillable = ['projet_id', 'annee_base', 'demande_globale_n1'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
