<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichePip extends Model
{
    protected $table = 'fiches_pip';
    protected $fillable = ['numero', 'nom', 'programme_id'];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'fiche_pip_projet');
    }
}
