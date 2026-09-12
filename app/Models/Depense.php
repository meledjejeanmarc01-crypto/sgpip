<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $fillable = ['libelle', 'montant', 'date', 'reference', 'projet_id'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
