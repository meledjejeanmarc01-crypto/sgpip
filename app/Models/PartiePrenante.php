<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartiePrenante extends Model
{
    protected $table = 'parties_prenantes';

    protected $fillable = ['groupe_acteurs', 'role', 'type_partie_prenante_id', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function typePartiePrenante()
    {
        return $this->belongsTo(TypePartiePrenante::class);
    }
}
