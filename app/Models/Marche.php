<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marche extends Model
{
    protected $fillable = ['objet', 'etat', 'duree', 'cout', 'montant_engage', 'montant_liquide', 'montant_paye', 'projet_id'];

    protected function casts(): array
    {
        return ['cout' => 'decimal:2', 'montant_engage' => 'decimal:2', 'montant_liquide' => 'decimal:2', 'montant_paye' => 'decimal:2'];
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function echeanciersAeCp()
    {
        return $this->hasMany(EcheancierAeCp::class, 'marche_id');
    }
}
