<?php

namespace App\Support;

use App\Models\Budget;
use App\Models\ChargeRecurrente;
use App\Models\Cible;
use App\Models\DemandeFinancement;
use App\Models\ComiteProjet;
use App\Models\CritereEvaluation;
use App\Models\EcheancierAeCp;
use App\Models\Marche;
use App\Models\OpportuniteEmploi;
use App\Models\PlanDecaissement;
use App\Models\PlanMiseEnOeuvreDetaille;
use App\Models\PlanMiseEnOeuvreGlobal;
use App\Models\PlanTravailAnnuel;
use App\Models\PrevisionValeur;
use App\Models\ProgrammationActiviteLf;
use App\Models\VentilationFinancementInterne;

/**
 * Volets de la fiche projet (canevas du Ministère) saisis depuis la fiche d'un projet.
 * Chaque volet décrit ses champs une seule fois ; le contrôleur, les règles de validation
 * et l'affichage s'en servent.
 *
 * Types de champs : text, textarea, number, year, select (avec options), et les listes propres au projet :
 * marche, financement, activite, composante.
 * Options d'affichage d'un volet : 'calcules' (colonnes calculées), 'totaux' (ligne de total), 'matrice' (tableau de synthèse).
 * 'scope' : projet | marche | financement | activite (la ligne dépend du projet directement ou via cette entité).
 */
class FicheVolets
{
    public static function definitions(): array
    {
        return [
            'beneficiaires' => [
                'titre' => 'Cibles et bénéficiaires', 'singulier' => 'Bénéficiaire', 'model' => Cible::class, 'scope' => 'projet',
                'aide' => 'Canevas, section 19 : bénéficiaires directs, indirects et acteurs de mise en œuvre.',
                'champs' => [
                    ['name' => 'type_beneficiaire', 'label' => 'Type', 'type' => 'select', 'required' => true, 'options' => ['direct' => 'Bénéficiaire direct', 'indirect' => 'Bénéficiaire indirect', 'mise_en_oeuvre' => 'Acteur de mise en œuvre']],
                    ['name' => 'groupe_acteur', 'label' => 'Groupe d\'acteurs', 'type' => 'text'],
                    ['name' => 'acteur', 'label' => 'Acteur', 'type' => 'text', 'required' => true],
                    ['name' => 'probleme_specifique', 'label' => 'Problème spécifique', 'type' => 'textarea'],
                    ['name' => 'attentes', 'label' => 'Attentes', 'type' => 'textarea'],
                    ['name' => 'craintes', 'label' => 'Craintes', 'type' => 'textarea'],
                    ['name' => 'taille', 'label' => 'Taille', 'type' => 'text'],
                ],
                'colonnes' => ['type_beneficiaire', 'groupe_acteur', 'acteur', 'taille'],
            ],
            'emplois' => [
                'titre' => 'Opportunités d\'emplois', 'singulier' => 'Opportunité d\'emploi', 'model' => OpportuniteEmploi::class, 'scope' => 'projet',
                'aide' => 'Canevas, section 23 : emplois directs et indirects, pendant la réalisation et l\'exploitation.',
                'champs' => [
                    ['name' => 'type_emploi', 'label' => 'Type d\'emploi', 'type' => 'select', 'required' => true, 'options' => ['direct' => 'Direct', 'indirect' => 'Indirect']],
                    ['name' => 'phase', 'label' => 'Phase', 'type' => 'select', 'required' => true, 'options' => ['realisation' => 'Réalisation du projet', 'exploitation' => 'Exploitation / fonctionnement']],
                    ['name' => 'nombre_emplois_prevus', 'label' => 'Nombre d\'emplois prévus', 'type' => 'number'],
                    ['name' => 'duree_activite_previsionnelle', 'label' => 'Durée prévisionnelle (mois)', 'type' => 'number'],
                ],
                'colonnes' => ['type_emploi', 'phase', 'nombre_emplois_prevus', 'duree_activite_previsionnelle'],
            ],
            'comites' => [
                'titre' => 'Cadre de gestion : comités et mécanismes', 'singulier' => 'Comité ou mécanisme', 'model' => ComiteProjet::class, 'scope' => 'projet',
                'aide' => 'Canevas, section 25 : comités de supervision, de pilotage, technique, et mécanismes de suivi-évaluation et d\'audit.',
                'champs' => [
                    ['name' => 'type', 'label' => 'Type', 'type' => 'select', 'required' => true, 'options' => ['supervision' => 'Comité de supervision', 'pilotage' => 'Comité de pilotage', 'technique' => 'Comité technique', 'suivi_evaluation' => 'Mécanisme de suivi-évaluation', 'audit_controle' => 'Mécanisme d\'audit et de contrôle']],
                    ['name' => 'role', 'label' => 'Rôle', 'type' => 'text'],
                    ['name' => 'composition', 'label' => 'Composition', 'type' => 'textarea'],
                    ['name' => 'observation', 'label' => 'Observation', 'type' => 'textarea'],
                ],
                'colonnes' => ['type', 'role', 'composition'],
            ],
            'charges' => [
                'titre' => 'Charges récurrentes', 'singulier' => 'Charge récurrente', 'model' => ChargeRecurrente::class, 'scope' => 'projet',
                'aide' => 'Canevas, section 30 et fiche d\'évaluation : fonctionnement, entretien, recouvrement.',
                'champs' => [
                    ['name' => 'rubrique', 'label' => 'Rubrique', 'type' => 'text', 'required' => true],
                    ['name' => 'categorie', 'label' => 'Catégorie', 'type' => 'select', 'options' => ['fonctionnement' => 'Fonctionnement', 'entretien' => 'Entretien', 'recouvrement' => 'Recouvrement des charges récurrentes']],
                    ['name' => 'annee', 'label' => 'Année', 'type' => 'year', 'required' => true],
                    ['name' => 'montant', 'label' => 'Montant (FCFA)', 'type' => 'number', 'required' => true],
                ],
                'colonnes' => ['rubrique', 'categorie', 'annee', 'montant'],
            ],
            'budgets' => [
                'titre' => 'Programmation budgétaire (prévisions par exercice)', 'singulier' => 'Exercice budgétaire', 'model' => Budget::class, 'scope' => 'projet',
                'aide' => 'Feuille Programmation : crédit budgétaire notifié, prise en charge antérieure, prévisions N, N+1, N+2.',
                'champs' => [
                    ['name' => 'exercice', 'label' => 'Exercice', 'type' => 'year', 'required' => true],
                    ['name' => 'credit_budgetaire_notifie', 'label' => 'Crédit budgétaire notifié', 'type' => 'number'],
                    ['name' => 'montant_pec_avant_exercice', 'label' => 'Prise en charge avant l\'exercice', 'type' => 'number'],
                    ['name' => 'montant_previsionnel_n', 'label' => 'Prévision N', 'type' => 'number'],
                    ['name' => 'montant_previsionnel_n1', 'label' => 'Prévision N+1', 'type' => 'number'],
                    ['name' => 'montant_previsionnel_n2', 'label' => 'Prévision N+2', 'type' => 'number'],
                    ['name' => 'taux_execution_financier', 'label' => 'Taux d\'exécution financier (%)', 'type' => 'number', 'max' => 100],
                    ['name' => 'taux_execution_physique', 'label' => 'Taux d\'exécution physique (%)', 'type' => 'number', 'max' => 100],
                    ['name' => 'observation', 'label' => 'Observation', 'type' => 'textarea'],
                ],
                'colonnes' => ['exercice', 'credit_budgetaire_notifie', 'montant_previsionnel_n', 'montant_previsionnel_n1', 'taux_execution_financier', 'taux_execution_physique'],
            ],
            'marches' => [
                'titre' => 'Marchés (fiche AE-CP)', 'singulier' => 'Marché', 'model' => Marche::class, 'scope' => 'projet',
                'aide' => 'Programmation, section 4 : objet de l\'opération, état, durée, coût, engagements et liquidations antérieurs. Les cumuls, restes à engager et charges à payer se calculent seuls.',
                'champs' => [
                    ['name' => 'objet', 'label' => 'Objet de l\'opération (marché)', 'type' => 'text', 'required' => true],
                    ['name' => 'etat', 'label' => 'État de l\'investissement', 'type' => 'select', 'options' => ['en_cours' => 'En cours de réalisation', 'nouveau' => 'Nouveau']],
                    ['name' => 'duree', 'label' => 'Durée', 'type' => 'text'],
                    ['name' => 'cout', 'label' => 'Coût du marché (h)', 'type' => 'number'],
                    ['name' => 'engagements_anterieurs_i1', 'label' => 'Engagements antérieurs : déc. N-2 (i1)', 'type' => 'number'],
                    ['name' => 'engagements_anterieurs_i2', 'label' => 'Engagements antérieurs : N-1 (i2)', 'type' => 'number'],
                    ['name' => 'liquidations_j1', 'label' => 'Liquidations antérieures : déc. N-2 (j1)', 'type' => 'number'],
                    ['name' => 'liquidations_j2', 'label' => 'Liquidations antérieures : juin N-1 (j2)', 'type' => 'number'],
                    ['name' => 'montant_paye', 'label' => 'Cumul des paiements (k)', 'type' => 'number'],
                ],
                'colonnes' => ['objet', 'etat', 'duree', 'cout', 'montant_paye'],
                'calcules' => [
                    ['name' => 'montant_engage', 'label' => 'Cumul des engagements antérieurs (i)', 'type' => 'number'],
                    ['name' => 'montant_liquide', 'label' => 'Cumul des liquidations antérieures (j)', 'type' => 'number'],
                    ['name' => 'restes_a_engager', 'label' => 'Restes à engager (AE) = h - i', 'type' => 'number'],
                    ['name' => 'charges_a_payer', 'label' => 'Charges à payer = j - k', 'type' => 'number'],
                ],
                'totaux' => ['cout', 'montant_paye', 'montant_engage', 'montant_liquide', 'restes_a_engager', 'charges_a_payer'],
            ],
            'echeanciers' => [
                'titre' => 'Échéancier AE-CP des marchés', 'singulier' => 'Échéance AE-CP', 'model' => EcheancierAeCp::class, 'scope' => 'marche',
                'aide' => 'Fiche AE-CP : autorisations d\'engagement (AE) et crédits de paiement (CP) par année de loi de finances.',
                'champs' => [
                    ['name' => 'marche_id', 'label' => 'Marché', 'type' => 'marche', 'required' => true],
                    ['name' => 'annee_lf', 'label' => 'Année de la loi de finances', 'type' => 'year', 'required' => true],
                    ['name' => 'montant_ae', 'label' => 'Montant AE', 'type' => 'number'],
                    ['name' => 'montant_cp', 'label' => 'Montant CP', 'type' => 'number'],
                ],
                'colonnes' => ['marche_id', 'annee_lf', 'montant_ae', 'montant_cp'],
            ],
            'criteres' => [
                'titre' => 'Critères d\'appréciation de l\'exécution', 'singulier' => 'Critère d\'appréciation', 'model' => CritereEvaluation::class, 'scope' => 'projet',
                'aide' => 'Feuille Suivi : efficacité, efficience, gestion du projet… avec appréciation et justification.',
                'champs' => [
                    ['name' => 'critere', 'label' => 'Critère', 'type' => 'text', 'required' => true],
                    ['name' => 'sous_critere', 'label' => 'Sous-critère', 'type' => 'text'],
                    ['name' => 'appreciation', 'label' => 'Appréciation', 'type' => 'select', 'options' => ['total' => 'Total', 'partiel' => 'Partiel', 'faible' => 'Faible', 'oui' => 'Oui', 'non' => 'Non']],
                    ['name' => 'justification', 'label' => 'Justification', 'type' => 'textarea'],
                ],
                'colonnes' => ['critere', 'sous_critere', 'appreciation', 'justification'],
            ],
            // ---------- Feuille PLANIFICATION ----------
            'ventilations' => [
                'titre' => 'Ventilation des coûts de financement interne', 'singulier' => 'Ligne de ventilation', 'model' => VentilationFinancementInterne::class, 'scope' => 'projet',
                'aide' => 'Planification, section 2 : pour chaque source interne, répartition en droits et taxes / hors droits et taxes, puis en numéraire (FUC, PAR, AO) / en nature.',
                'champs' => [
                    ['name' => 'source', 'label' => 'Source de financement interne', 'type' => 'text', 'required' => true],
                    ['name' => 'droits_taxes', 'label' => 'Droits et taxes', 'type' => 'number'],
                    ['name' => 'hors_droits_taxes', 'label' => 'Hors droits et taxes', 'type' => 'number'],
                    ['name' => 'numeraire_fuc', 'label' => 'Numéraire (FUC)', 'type' => 'number'],
                    ['name' => 'numeraire_par', 'label' => 'Numéraire (PAR)', 'type' => 'number'],
                    ['name' => 'numeraire_ao', 'label' => 'Numéraire (AO)', 'type' => 'number'],
                    ['name' => 'nature_montant', 'label' => 'En nature (montant)', 'type' => 'number'],
                    ['name' => 'nature_designation', 'label' => 'En nature (désignation)', 'type' => 'text'],
                    ['name' => 'observation', 'label' => 'Observation', 'type' => 'textarea'],
                ],
                'colonnes' => ['source', 'droits_taxes', 'hors_droits_taxes', 'numeraire_fuc', 'numeraire_par', 'numeraire_ao', 'nature_montant'],
                'calcules' => [
                    ['name' => 'total_taxes', 'label' => 'Total (droits + hors droits)', 'type' => 'number'],
                    ['name' => 'total_modalites', 'label' => 'Total (numéraire + nature)', 'type' => 'number'],
                ],
                'totaux' => ['droits_taxes', 'hors_droits_taxes', 'numeraire_fuc', 'numeraire_par', 'numeraire_ao', 'nature_montant', 'total_taxes', 'total_modalites'],
            ],
            'plan_decaissement' => [
                'titre' => 'Plan de décaissement', 'singulier' => 'Montant prévu', 'model' => PlanDecaissement::class, 'scope' => 'financement',
                'aide' => 'Planification, section 4 : montant de décaissement prévu, par financement et par année.',
                'champs' => [
                    ['name' => 'financement_id', 'label' => 'Financement', 'type' => 'financement', 'required' => true],
                    ['name' => 'annee', 'label' => 'Année', 'type' => 'year', 'required' => true],
                    ['name' => 'montant', 'label' => 'Montant prévu (FCFA)', 'type' => 'number', 'required' => true],
                ],
                'colonnes' => ['financement_id', 'annee', 'montant'],
                'totaux' => ['montant'],
                'matrice' => ['ligne' => 'financement_id', 'colonne' => 'annee', 'valeur' => 'montant', 'titre' => 'Financement'],
            ],
            'plan_global' => [
                'titre' => 'Plan de mise en œuvre global', 'singulier' => 'Période d\'une composante', 'model' => PlanMiseEnOeuvreGlobal::class, 'scope' => 'composante',
                'aide' => 'Planification, section 5 : début et fin prévisionnels de mise en œuvre de chaque composante (année et semestre).',
                'champs' => [
                    ['name' => 'composante_id', 'label' => 'Composante du projet', 'type' => 'composante', 'required' => true],
                    ['name' => 'annee_debut', 'label' => 'Année de début', 'type' => 'year', 'required' => true],
                    ['name' => 'semestre_debut', 'label' => 'Semestre de début', 'type' => 'select', 'required' => true, 'options' => ['1' => 'Semestre 1', '2' => 'Semestre 2']],
                    ['name' => 'annee_fin', 'label' => 'Année de fin', 'type' => 'year', 'required' => true],
                    ['name' => 'semestre_fin', 'label' => 'Semestre de fin', 'type' => 'select', 'required' => true, 'options' => ['1' => 'Semestre 1', '2' => 'Semestre 2']],
                ],
                'colonnes' => ['composante_id', 'annee_debut', 'semestre_debut', 'annee_fin', 'semestre_fin'],
            ],
            'plan_detaille' => [
                'titre' => 'Plan de mise en œuvre détaillé', 'singulier' => 'Montant prévisionnel', 'model' => PlanMiseEnOeuvreDetaille::class, 'scope' => 'activite',
                'aide' => 'Planification, section 6 : montant prévisionnel (FCFA) de chaque activité, par année d\'exécution. Les dates de début et de fin viennent de l\'activité.',
                'champs' => [
                    ['name' => 'activite_id', 'label' => 'Activité', 'type' => 'activite', 'required' => true],
                    ['name' => 'annee', 'label' => 'Année d\'exécution', 'type' => 'year', 'required' => true],
                    ['name' => 'montant', 'label' => 'Montant prévisionnel (FCFA)', 'type' => 'number', 'required' => true],
                ],
                'colonnes' => ['activite_id', 'annee', 'montant'],
                'totaux' => ['montant'],
                'matrice' => ['ligne' => 'activite_id', 'colonne' => 'annee', 'valeur' => 'montant', 'titre' => 'Activité'],
            ],
            'plan_travail' => [
                'titre' => 'Plan de travail budgétisé annuel', 'singulier' => 'Ligne du plan de travail', 'model' => PlanTravailAnnuel::class, 'scope' => 'activite',
                'aide' => 'Planification, section 7 : pour un exercice budgétaire, crédit, durée, indicateur d\'activité, cible, structure responsable et niveau d\'exécution prévu par trimestre.',
                'champs' => [
                    ['name' => 'activite_id', 'label' => 'Activité', 'type' => 'activite', 'required' => true],
                    ['name' => 'exercice', 'label' => 'Exercice budgétaire', 'type' => 'year', 'required' => true],
                    ['name' => 'credit_budgetaire', 'label' => 'Crédit budgétaire (FCFA)', 'type' => 'number'],
                    ['name' => 'duree_mois', 'label' => 'Durée de réalisation (mois)', 'type' => 'number'],
                    ['name' => 'indicateur_libelle', 'label' => 'Indicateur d\'activité', 'type' => 'text'],
                    ['name' => 'cible', 'label' => 'Cible', 'type' => 'number'],
                    ['name' => 'structure_responsable', 'label' => 'Structure responsable', 'type' => 'text'],
                    ['name' => 't1', 'label' => 'Exécution prévue T1 (%)', 'type' => 'number', 'max' => 100, 'unite' => '%'],
                    ['name' => 't2', 'label' => 'Exécution prévue T2 (%)', 'type' => 'number', 'max' => 100, 'unite' => '%'],
                    ['name' => 't3', 'label' => 'Exécution prévue T3 (%)', 'type' => 'number', 'max' => 100, 'unite' => '%'],
                    ['name' => 't4', 'label' => 'Exécution prévue T4 (%)', 'type' => 'number', 'max' => 100, 'unite' => '%'],
                ],
                'colonnes' => ['activite_id', 'exercice', 'credit_budgetaire', 'duree_mois', 'indicateur_libelle', 'cible', 'structure_responsable', 't1', 't2', 't3', 't4'],
                'totaux' => ['credit_budgetaire'],
            ],
            // ---------- Feuille PROGRAMMATION ----------
            'demande_financement' => [
                'titre' => 'Demande de financement de l\'année de programmation', 'singulier' => 'Demande de financement', 'model' => DemandeFinancement::class, 'scope' => 'projet',
                'aide' => 'Programmation, section 1 : année de base de la programmation et demande globale de financement pour N+1.',
                'champs' => [
                    ['name' => 'annee_base', 'label' => 'Année de base de programmation', 'type' => 'year', 'required' => true],
                    ['name' => 'demande_globale_n1', 'label' => 'Demande globale N+1 (FCFA)', 'type' => 'number'],
                ],
                'colonnes' => ['annee_base', 'demande_globale_n1'],
            ],
            'previsions_valeur' => [
                'titre' => 'Échéancier des prévisions en valeur', 'singulier' => 'Ligne de prévision', 'model' => PrevisionValeur::class, 'scope' => 'projet',
                'aide' => 'Programmation, section 2 : par source de financement, prises en charge (PEC) antérieures, crédit budgétaire de l\'année N et prévisions N+1 et N+2. Pour un projet cofinancé, indiquer le bailleur et, pour la contrepartie de l\'État, la rubrique.',
                'champs' => [
                    ['name' => 'type_echeancier', 'label' => 'Type de projet', 'type' => 'select', 'required' => true, 'options' => ['exclusif' => 'Exclusivement financé sur ressources nationales (2.1)', 'cofinance' => 'Cofinancé (2.2)']],
                    ['name' => 'nature', 'label' => 'Nature de la source de financement', 'type' => 'select', 'required' => true, 'options' => ['1' => '1 - Trésor', '2' => '2 - Emprunts', '3' => '3 - Dons', '4' => '4 - Participation des collectivités territoriales', '5' => '5 - Participation des populations', '6' => '6 - Participation du secteur privé et autres', '7' => '7 - Partenariats publics privés', '8' => '8 - Fonds propres parapublics', '9' => '9 - Emprunts parapublics']],
                    ['name' => 'bailleur_guichet', 'label' => 'Bailleur / guichet', 'type' => 'text'],
                    ['name' => 'rubrique', 'label' => 'Rubrique (contrepartie de l\'État)', 'type' => 'select', 'options' => ['contrepartie' => 'Contrepartie de l\'État (total)', 'droits_taxes' => 'Droits et taxes', 'hors_droits_taxes' => 'Hors droits et taxes', 'fuc' => 'FUC', 'par' => 'PAR', 'ao' => 'AO']],
                    ['name' => 'annee_base', 'label' => 'Exercice de base (N)', 'type' => 'year', 'required' => true],
                    ['name' => 'montant_total', 'label' => 'Montant total', 'type' => 'number'],
                    ['name' => 'pec_avant', 'label' => 'PEC avant N-3', 'type' => 'number'],
                    ['name' => 'pec_n3', 'label' => 'PEC N-3', 'type' => 'number'],
                    ['name' => 'pec_n2', 'label' => 'PEC N-2', 'type' => 'number'],
                    ['name' => 'pec_n1', 'label' => 'PEC N-1', 'type' => 'number'],
                    ['name' => 'credit_budgetaire_n', 'label' => 'Crédit budgétaire N', 'type' => 'number'],
                    ['name' => 'prevision_n1', 'label' => 'Prévision N+1', 'type' => 'number'],
                    ['name' => 'prevision_n2', 'label' => 'Prévision N+2', 'type' => 'number'],
                    ['name' => 'apres', 'label' => 'Après N+2', 'type' => 'number'],
                ],
                'colonnes' => ['type_echeancier', 'nature', 'bailleur_guichet', 'rubrique', 'annee_base', 'montant_total', 'pec_avant', 'pec_n3', 'pec_n2', 'pec_n1', 'credit_budgetaire_n', 'prevision_n1', 'prevision_n2', 'apres'],
                'calcules' => [['name' => 'total_periode', 'label' => 'Total N à N+2', 'type' => 'number']],
                'totaux' => ['montant_total', 'pec_avant', 'pec_n3', 'pec_n2', 'pec_n1', 'credit_budgetaire_n', 'prevision_n1', 'prevision_n2', 'total_periode', 'apres'],
            ],
            'programmation_lf' => [
                'titre' => 'Programmation des activités à soumettre à la loi de finances', 'singulier' => 'Activité programmée', 'model' => ProgrammationActiviteLf::class, 'scope' => 'activite',
                'aide' => 'Programmation, section 3 : pour chaque activité, livrable, nature économique, source de financement, coût total, prises en charge antérieures, crédit budgétaire et prévisions. Le reste à financer se calcule seul.',
                'champs' => [
                    ['name' => 'activite_id', 'label' => 'Activité', 'type' => 'activite', 'required' => true],
                    ['name' => 'annee_base', 'label' => 'Exercice de base (N)', 'type' => 'year', 'required' => true],
                    ['name' => 'livrable', 'label' => 'Livrable', 'type' => 'textarea'],
                    ['name' => 'nature_economique_code', 'label' => 'Nature économique (code)', 'type' => 'text'],
                    ['name' => 'nature_economique_libelle', 'label' => 'Nature économique (libellé)', 'type' => 'text'],
                    ['name' => 'type_financement', 'label' => 'Type de financement', 'type' => 'text'],
                    ['name' => 'bailleur_guichet', 'label' => 'Bailleur / guichet', 'type' => 'text'],
                    ['name' => 'cout_total', 'label' => 'Coût total (FCFA)', 'type' => 'number'],
                    ['name' => 'cumul_pec_avant', 'label' => 'Cumul des prises en charge avant N', 'type' => 'number'],
                    ['name' => 'credit_budgetaire_n', 'label' => 'Crédit budgétaire N', 'type' => 'number'],
                    ['name' => 'prevision_n1', 'label' => 'Prévision N+1', 'type' => 'number'],
                    ['name' => 'prevision_n2', 'label' => 'Prévision N+2', 'type' => 'number'],
                    ['name' => 'prevision_n3', 'label' => 'Prévision N+3', 'type' => 'number'],
                ],
                'colonnes' => ['activite_id', 'annee_base', 'nature_economique_code', 'type_financement', 'cout_total', 'cumul_pec_avant', 'credit_budgetaire_n', 'prevision_n1', 'prevision_n2', 'prevision_n3'],
                'calcules' => [
                    ['name' => 'composante_libelle', 'label' => 'Composante', 'type' => 'text'],
                    ['name' => 'reste_a_financer', 'label' => 'Reste à financer', 'type' => 'number'],
                ],
                'totaux' => ['cout_total', 'cumul_pec_avant', 'credit_budgetaire_n', 'prevision_n1', 'prevision_n2', 'prevision_n3', 'reste_a_financer'],
            ],
        ];
    }

    public static function get(string $volet): array
    {
        $definitions = self::definitions();
        abort_unless(isset($definitions[$volet]), 404);

        return $definitions[$volet];
    }

    public static function regles(array $def): array
    {
        $regles = [];
        foreach ($def['champs'] as $c) {
            $r = [($c['required'] ?? false) ? 'required' : 'nullable'];
            switch ($c['type']) {
                case 'number':
                    $r[] = 'numeric';
                    $r[] = 'min:0';
                    if (isset($c['max'])) {
                        $r[] = 'max:'.$c['max'];
                    }
                    break;
                case 'year':
                    $r[] = 'integer';
                    $r[] = 'min:2000';
                    $r[] = 'max:2100';
                    break;
                case 'select':
                    $r[] = 'in:'.implode(',', array_keys($c['options']));
                    break;
                case 'marche':
                    $r[] = 'exists:marches,id';
                    break;
                case 'financement':
                    $r[] = 'exists:financements,id';
                    break;
                case 'activite':
                    $r[] = 'exists:activites,id';
                    break;
                case 'composante':
                    $r[] = 'exists:composantes,id';
                    break;
                case 'textarea':
                    $r[] = 'string';
                    break;
                default:
                    $r[] = 'string';
                    $r[] = 'max:255';
            }
            $regles[$c['name']] = implode('|', $r);
        }

        return $regles;
    }

    /** Noms affichés dans les messages de validation. */
    public static function attributs(array $def): array
    {
        $attributs = [];
        foreach ($def['champs'] as $c) {
            $attributs[$c['name']] = mb_strtolower($c['label']);
        }

        return $attributs;
    }
}
