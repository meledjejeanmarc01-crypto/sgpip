<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $fillable = ['libelle', 'sigle', 'adresse', 'telephone', 'email', 'type_structure_id'];

    public function typeStructure()
    {
        return $this->belongsTo(TypeStructure::class, 'type_structure_id');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }

    public function programmes()
    {
        return $this->hasMany(Programme::class);
    }
}
