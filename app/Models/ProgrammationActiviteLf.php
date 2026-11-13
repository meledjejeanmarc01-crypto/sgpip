<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Feuille PROGRAMMATION, section 3 : table « programmation_activites_lf ».
class ProgrammationActiviteLf extends Model
{
    protected $table = 'programmation_activites_lf';

    protected $fillable = [
        'activite_id', 'annee_base', 'livrable', 'nature_economique_code', 'nature_economique_libelle',
        'type_financement', 'bailleur_guichet', 'cout_total', 'cumul_pec_avant', 'credit_budgetaire_n',
        'prevision_n1', 'prevision_n2', 'prevision_n3',
    ];

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }

    // Composante de l'activité (colonne « Composantes » du canevas).
    public function getComposanteLibelleAttribute(): ?string
    {
        return optional(optional($this->activite)->composante)->libelle;
    }

    // Reste à financer = coût total - prises en charge antérieures - crédit et prévisions des 4 années.
    public function getResteAFinancerAttribute(): float
    {
        return (float) $this->cout_total
            - ((float) $this->cumul_pec_avant + (float) $this->credit_budgetaire_n + (float) $this->prevision_n1
                + (float) $this->prevision_n2 + (float) $this->prevision_n3);
    }
}
