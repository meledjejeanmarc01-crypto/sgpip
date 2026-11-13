<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    protected $fillable = ['nom', 'libelle', 'axe_strategique', 'code', 'date_debut', 'date_fin', 'structure_id'];

    protected function casts(): array
    {
        return ['date_debut' => 'date', 'date_fin' => 'date'];
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function fichesPip()
    {
        return $this->hasMany(FichePip::class);
    }

    public function axes()
    {
        return $this->hasMany(Axe::class);
    }
}
