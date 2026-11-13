<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Feuille PROGRAMMATION, section 2 : table « previsions_valeur ».
class PrevisionValeur extends Model
{
    protected $table = 'previsions_valeur';

    protected $fillable = [
        'projet_id', 'type_echeancier', 'nature', 'bailleur_guichet', 'rubrique', 'annee_base', 'montant_total',
        'pec_avant', 'pec_n3', 'pec_n2', 'pec_n1', 'credit_budgetaire_n', 'prevision_n1', 'prevision_n2', 'apres',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    // Total de la période : crédit budgétaire N + prévisions N+1 et N+2 (colonne « TOTAL » du canevas).
    public function getTotalPeriodeAttribute(): float
    {
        return (float) $this->credit_budgetaire_n + (float) $this->prevision_n1 + (float) $this->prevision_n2;
    }
}
