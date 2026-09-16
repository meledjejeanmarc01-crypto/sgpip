<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupeActeur extends Model
{
    protected $table = 'groupes_acteur';
    protected $fillable = ['libelle'];

    public function acteurs()
    {
        return $this->hasMany(Acteur::class);
    }
}
