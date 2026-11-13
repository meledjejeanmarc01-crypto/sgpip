<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Volet de la fiche projet (canevas du Ministère) : table « charges_recurrentes ».
class ChargeRecurrente extends Model
{
    protected $table = 'charges_recurrentes';

    protected $fillable = ['rubrique', 'categorie', 'montant', 'annee', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
