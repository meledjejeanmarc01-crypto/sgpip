<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reforme extends Model
{
    protected $fillable = [
        'libelle', 'description', 'resultat_global_attendu', 'statut', 'date_transmission_sgg',
        'annee_debut', 'annee_fin', 'taux_execution_annee_precedente', 'taux_execution_previsionnel',
        'cible_trimestre_1', 'cible_trimestre_2', 'cible_trimestre_3', 'cible_trimestre_4',
        'localite', 'budget_global', 'source_financement', 'montant_etat', 'montant_autres_bailleurs',
        'livrables_attendus', 'indicateurs', 'code_pjgouv', 'code_psgouv', 'observations',
        'structure_id', 'axe_id',
    ];

    protected function casts(): array
    {
        return ['date_transmission_sgg' => 'date'];
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function axe()
    {
        return $this->belongsTo(Axe::class);
    }
}
