<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portefeuille extends Model
{
    protected $fillable = ['appartenance_pnd', 'libelle_associe', 'projet_id'];
    protected $casts = ['appartenance_pnd' => 'boolean'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
