<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objectif extends Model
{
    protected $fillable = ['libelle', 'description', 'type_objectif_id', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function typeObjectif()
    {
        return $this->belongsTo(TypeObjectif::class);
    }

    public function resultatsAttendus()
    {
        return $this->hasMany(ResultatAttendu::class);
    }
}
