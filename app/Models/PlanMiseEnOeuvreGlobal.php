<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Feuille PLANIFICATION du canevas : table « plans_mise_en_oeuvre_global ».
class PlanMiseEnOeuvreGlobal extends Model
{
    protected $table = 'plans_mise_en_oeuvre_global';

    protected $fillable = ['composante_id', 'annee_debut', 'semestre_debut', 'annee_fin', 'semestre_fin'];

    public function composante()
    {
        return $this->belongsTo(Composante::class);
    }
}
