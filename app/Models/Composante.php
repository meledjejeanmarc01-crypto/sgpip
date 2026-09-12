<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Composante extends Model
{
    protected $fillable = ['libelle', 'budget_previsionnel', 'projet_id'];

    protected function casts(): array
    {
        return ['budget_previsionnel' => 'decimal:2'];
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function activites()
    {
        return $this->hasMany(Activite::class);
    }
}
