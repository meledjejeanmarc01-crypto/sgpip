<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    protected $fillable = ['intitule', 'date_debut', 'date_fin', 'taux_avancement', 'cout_previsionnel', 'projet_id', 'composante_id'];

    protected function casts(): array
    {
        return ['date_debut' => 'date', 'date_fin' => 'date'];
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

    public function indicateurs()
    {
        return $this->hasMany(Indicateur::class);
    }

    public function composante()
    {
        return $this->belongsTo(Composante::class);
    }

    /** Projet auquel cet élément est rattaché. */
    public function projetAssocie(): ?Projet
    {
        return $this->projet;
    }
}
