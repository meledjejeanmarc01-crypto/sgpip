<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Feuille PLANIFICATION du canevas : table « ventilations_financement_interne ».
class VentilationFinancementInterne extends Model
{
    protected $table = 'ventilations_financement_interne';

    protected $fillable = ['projet_id', 'source', 'droits_taxes', 'hors_droits_taxes', 'numeraire_fuc', 'numeraire_par', 'numeraire_ao', 'nature_montant', 'nature_designation', 'observation'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    // Total de la répartition « droits et taxes » + « hors droits et taxes ».
    public function getTotalTaxesAttribute(): float
    {
        return (float) $this->droits_taxes + (float) $this->hors_droits_taxes;
    }

    // Total de la répartition « en numéraire » (FUC + PAR + AO) + « en nature ».
    public function getTotalModalitesAttribute(): float
    {
        return (float) $this->numeraire_fuc + (float) $this->numeraire_par + (float) $this->numeraire_ao + (float) $this->nature_montant;
    }
}
