<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Volet de la fiche projet (canevas du Ministère) : table « budgets ».
class Budget extends Model
{
    protected $table = 'budgets';

    protected $fillable = ['exercice', 'credit_budgetaire_notifie', 'montant_pec_avant_exercice', 'montant_previsionnel_n', 'montant_previsionnel_n1', 'montant_previsionnel_n2', 'taux_execution_financier', 'taux_execution_physique', 'observation', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
