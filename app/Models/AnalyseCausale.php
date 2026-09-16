<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyseCausale extends Model
{
    protected $table = 'analyses_causales';
    protected $fillable = ['libelle', 'type_analyse_causale_id', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function typeAnalyseCausale()
    {
        return $this->belongsTo(TypeAnalyseCausale::class);
    }
}
