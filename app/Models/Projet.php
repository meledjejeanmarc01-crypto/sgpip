<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $fillable = [
        'reference', 'code_pip', 'intitule', 'contexte', 'objectif', 'cout_estimatif',
        'date_debut', 'date_fin', 'avancement_physique', 'statut',
        'maitre_ouvrage', 'maitre_ouvrage_delegue', 'maitre_oeuvre', 'duree_prevue',
        'programme_budgetaire', 'odd_concerne', 'domaine_impact_socio_eco',
        'type_projet',
        'cible_trimestre_1', 'cible_trimestre_2', 'cible_trimestre_3', 'cible_trimestre_4',
        'code_pjgouv', 'code_psgouv', 'appartenance', 'probleme', 'attentes_projet', 'craintes_projet',
        'taille', 'observations',
        'structure_id', 'secteur_id', 'axe_id', 'action_pnd_id',
        'date_identification', 'maitre_ouvrage_associe', 'maitre_oeuvre_delegue', 'maitre_oeuvre_associe', 'section_budgetaire',
        'responsable_nom', 'responsable_fonction', 'responsable_telephone', 'responsable_cellulaire', 'responsable_email', 'responsable_adresse',
        'redacteur_nom', 'redacteur_fonction', 'redacteur_telephone', 'redacteur_cellulaire', 'redacteur_email', 'redacteur_adresse',
        'perimetre_sections', 'attributions_ministere',
        'partenaires_projet', 'plan_implementation', 'charges_recurrentes_date_debut', 'charges_recurrentes_duree',
        'appartient_portefeuille_pnd', 'portefeuille_pnd_projets', 'ancrage_document_source', 'ancrage_objectifs_strategies',
        'statut_validation', 'motif_decision', 'date_soumission', 'date_decision', 'decide_par',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
            'date_identification' => 'date',
            'perimetre_sections' => 'array',
            'appartient_portefeuille_pnd' => 'boolean',
            'charges_recurrentes_date_debut' => 'date',
            'date_soumission' => 'datetime',
            'date_decision' => 'datetime',
            'cout_estimatif' => 'decimal:2',
        ];
    }

    // RG17 : un projet est géré par un ou plusieurs utilisateurs.
    public function gestionnaires()
    {
        return $this->belongsToMany(User::class, 'projet_user')->withTimestamps();
    }

    public function decideur()
    {
        return $this->belongsTo(User::class, 'decide_par');
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    // RG41 : un projet appartient à plusieurs zones d'exécution.
    public function zonesExecution()
    {
        return $this->belongsToMany(ZoneLocalisation::class, 'projet_zone_execution', 'projet_id', 'zone_localisation_id');
    }

    // RG37 : un projet peut avoir plusieurs milieux d'exécution.
    public function milieuxExecution()
    {
        return $this->hasMany(MilieuExecution::class);
    }

    // RG40 : un projet n'est rattaché qu'à une seule action PND.
    public function actionPnd()
    {
        return $this->belongsTo(ActionPnd::class);
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

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function axe()
    {
        return $this->belongsTo(Axe::class);
    }

    public function composantes()
    {
        return $this->hasMany(Composante::class);
    }

    // Volets de la fiche projet (canevas du Ministère)
    public function cibles() { return $this->hasMany(Cible::class); }
    public function opportunitesEmploi() { return $this->hasMany(OpportuniteEmploi::class); }
    public function comitesProjet() { return $this->hasMany(ComiteProjet::class); }
    public function chargesRecurrentes() { return $this->hasMany(ChargeRecurrente::class); }
    public function criteresEvaluation() { return $this->hasMany(CritereEvaluation::class); }
    public function budgets() { return $this->hasMany(Budget::class); }
    public function marches() { return $this->hasMany(Marche::class); }

    public function risques()
    {
        return $this->hasMany(Risque::class);
    }

    public function partiesPrenantes()
    {
        return $this->hasMany(PartiePrenante::class);
    }

    public function etudes()
    {
        return $this->hasMany(Etude::class);
    }

    // RG38 : un projet peut avoir plusieurs objectifs spécifiques.
    public function objectifsSpecifiques()
    {
        return $this->hasMany(ObjectifSpecifique::class);
    }

    public function analysesCausales()
    {
        return $this->hasMany(AnalyseCausale::class);
    }

    // RG36 : un projet peut impliquer plusieurs acteurs.
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
