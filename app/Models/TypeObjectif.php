<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeObjectif extends Model
{
    protected $table = 'types_objectif';
    protected $fillable = ['libelle'];

    public function objectifs()
    {
        return $this->hasMany(Objectif::class);
    }
}
