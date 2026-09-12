<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeRecurrente extends Model
{
    protected $table = 'charges_recurrentes';

    protected $fillable = ['rubrique', 'categorie', 'montant', 'annee', 'projet_id'];

    protected function casts(): array
    {
        return ['montant' => 'decimal:2'];
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
