<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartiePrenante extends Model
{
    protected $table = 'parties_prenantes';

    protected $fillable = ['groupe_acteurs', 'role', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
