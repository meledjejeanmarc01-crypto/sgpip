<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeAnalyseCausale extends Model
{
    protected $table = 'types_analyse_causale';
    protected $fillable = ['libelle'];

    public function analysesCausales()
    {
        return $this->hasMany(AnalyseCausale::class);
    }
}
