<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etude extends Model
{
    protected $fillable = ['libelle', 'mode_execution', 'structure_realisation', 'budget', 'date_demarrage', 'duree', 'etat_execution', 'projet_id'];

    protected function casts(): array
    {
        return ['date_demarrage' => 'date', 'budget' => 'decimal:2'];
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
