<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeStructure extends Model
{
    protected $table = 'types_structure';
    protected $fillable = ['libelle'];

    public function structures()
    {
        return $this->hasMany(Structure::class);
    }
}
