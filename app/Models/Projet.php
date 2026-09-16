<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $fillable = [
        'reference', 'code_pip', 'intitule', 'contexte', 'objectif', 'cout_estimatif',
        'date_debut', 'date_fin', 'avancement_physique', 'statut',
        'maitre_ouvrage', 'maitre_ouvrage_delegue', 'maitre_oeuvre', 'duree_prevue',
        'action_pnd', 'programme_budgetaire', 'odd_concerne', 'domaine_impact_socio_eco',
        'milieu_execution', 'type_projet',
        'cible_trimestre_1', 'cible_trimestre_2', 'cible_trimestre_3', 'cible_trimestre_4',
        'code_pjgouv', 'code_psgouv', 'appartenance', 'probleme', 'attentes_projet', 'craintes_projet',
        'taille', 'observations',
        'structure_id', 'secteur_id', 'zone_localisation_id', 'axe_id',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
            'cout_estimatif' => 'decimal:2',
        ];
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    public function zoneLocalisation()
    {
        return $this->belongsTo(ZoneLocalisation::class, 'zone_localisation_id');
    }

    public function fichesPip()
    {
        return $this->belongsToMany(FichePip::class, 'fiche_pip_projet');
    }

    public function activites()
    {
        return $this->hasMany(Activite::class);
    }

    public function financements()
    {
        return $this->hasMany(Financement::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class);
    }

    public function piecesJustificatives()
    {
        return $this->hasMany(PieceJustificative::class);
    }

    public function axe()
    {
        return $this->belongsTo(Axe::class);
    }

    public function composantes()
    {
        return $this->hasMany(Composante::class);
    }

    public function risques()
    {
        return $this->hasMany(Risque::class);
    }

    public function partiesPrenantes()
    {
        return $this->hasMany(PartiePrenante::class);
    }

    public function cibles()
    {
        return $this->hasMany(Cible::class);
    }

    public function etudes()
    {
        return $this->hasMany(Etude::class);
    }

    public function chargesRecurrentes()
    {
        return $this->hasMany(ChargeRecurrente::class);
    }

    public function marches()
    {
        return $this->hasMany(Marche::class);
    }

    public function objectifsSpecifiques()
    {
        return $this->hasMany(ObjectifSpecifique::class);
    }

    public function objectifs()
    {
        return $this->hasMany(Objectif::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function portefeuilles()
    {
        return $this->hasMany(Portefeuille::class);
    }

    public function comitesProjet()
    {
        return $this->hasMany(ComiteProjet::class);
    }

    public function criteresEvaluation()
    {
        return $this->hasMany(CritereEvaluation::class);
    }

    public function opportunitesEmploi()
    {
        return $this->hasMany(OpportuniteEmploi::class);
    }

    public function analysesCausales()
    {
        return $this->hasMany(AnalyseCausale::class);
    }

    public function acteurs()
    {
        return $this->belongsToMany(Acteur::class, 'acteur_projet');
    }

    public function getMontantEngageAttribute(): float
    {
        return (float) $this->financements()->sum('montant_engage');
    }

    public function getMontantDecaisseAttribute(): float
    {
        return (float) \App\Models\Decaissement::whereIn('financement_id', $this->financements()->pluck('id'))->sum('montant');
    }

    public function getMontantDepenseAttribute(): float
    {
        return (float) $this->depenses()->sum('montant');
    }
}
