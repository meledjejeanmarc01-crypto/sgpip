<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePartiePrenante extends Model
{
    protected $table = 'types_partie_prenante';
    protected $fillable = ['libelle'];

    public function partiesPrenantes()
    {
        return $this->hasMany(PartiePrenante::class);
    }
}
