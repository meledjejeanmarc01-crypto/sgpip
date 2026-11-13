<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CibleTrimestrielle extends Model
{
    protected $table = 'cibles_trimestrielles';

    protected $fillable = ['trimestre', 'valeur_cible', 'indicateur_id'];

    public function indicateur()
    {
        return $this->belongsTo(Indicateur::class);
    }
}
