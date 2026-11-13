<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Feuille PLANIFICATION du canevas : table « plans_travail_annuel ».
class PlanTravailAnnuel extends Model
{
    protected $table = 'plans_travail_annuel';

    protected $fillable = ['activite_id', 'exercice', 'credit_budgetaire', 'duree_mois', 'indicateur_libelle', 'cible', 'structure_responsable', 't1', 't2', 't3', 't4'];

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }
}
