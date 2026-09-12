<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeBailleur extends Model
{
    protected $table = 'types_bailleur';
    protected $fillable = ['libelle'];

    public function bailleurs()
    {
        return $this->hasMany(Bailleur::class);
    }
}
