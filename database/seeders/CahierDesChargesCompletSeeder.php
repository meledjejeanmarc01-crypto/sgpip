<?php

namespace Database\Seeders;

use App\Models\Acteur;
use App\Models\ActionPnd;
use App\Models\AnalyseCausale;
use App\Models\Axe;
use App\Models\Composante;
use App\Models\ConventionFinancement;
use App\Models\Document;
use App\Models\Etude;
use App\Models\GroupeActeur;
use App\Models\MilieuExecution;
use App\Models\ObjectifSpecifique;
use App\Models\PartiePrenante;
use App\Models\PaysEtranger;
use App\Models\Programme;
use App\Models\Projet;
use App\Models\Reforme;
use App\Models\ResultatAttendu;
use App\Models\Risque;
use App\Models\Structure;
use App\Models\TypeAnalyseCausale;
use App\Models\TypeDocument;
use App\Models\TypePartiePrenante;
use App\Models\User;
use Illuminate\Database\Seeder;

// Complète les entités du cahier des charges qui n'avaient encore aucun enregistrement
// (tout ce qui n'est pas la table "projets", déjà peuplée par ProjetDemoSeeder).
// D'abord les tables de référence, puis des données rattachées à chacun des projets
// existants, pour que chaque entité soit réellement utilisée dans l'application.
class CahierDesChargesCompletSeeder extends Seeder
{
    public function run(): void
    {
        $this->referentiels();
        $this->axesEtReformes();
        $this->parProjet();
    }

    /* ------------------------------------------------------------------ */
    /* 1. Tables de référence (indépendantes des projets)                  */
    /* ------------------------------------------------------------------ */
    private function referentiels(): void
    {
        foreach (['Bénéficiaires directs', 'Bénéficiaires indirects', 'Structure exécutante', 'Partenaire technique et financier', 'Collectivité territoriale'] as $libelle) {
            TypePartiePrenante::firstOrCreate(['libelle' => $libelle]);
        }

        foreach (['Administration publique', 'Collectivités territoriales', 'Société civile', 'Secteur privé', 'Partenaires techniques et financiers'] as $libelle) {
            GroupeActeur::firstOrCreate(['libelle' => $libelle]);
        }

        $administration = GroupeActeur::where('libelle', 'Administration publique')->first();
        $collectivites = GroupeActeur::where('libelle', 'Collectivités territoriales')->first();
        $societeCivile = GroupeActeur::where('libelle', 'Société civile')->first();
        $secteurPrive = GroupeActeur::where('libelle', 'Secteur privé')->first();
        $ptf = GroupeActeur::where('libelle', 'Partenaires techniques et financiers')->first();

        $acteurs = [
            ['libelle' => 'Ministère du Plan et du Développement', 'role' => 'Tutelle technique', 'groupe_acteur_id' => $administration->id],
            ['libelle' => "Ministère de l'Économie et des Finances", 'role' => 'Tutelle financière', 'groupe_acteur_id' => $administration->id],
            ['libelle' => 'Conseil Régional du Poro', 'role' => 'Maître d\'ouvrage local', 'groupe_acteur_id' => $collectivites->id],
            ['libelle' => "Mairie d'Abidjan", 'role' => 'Maître d\'ouvrage local', 'groupe_acteur_id' => $collectivites->id],
            ['libelle' => 'Association des Consommateurs de Côte d\'Ivoire', 'role' => 'Suivi citoyen', 'groupe_acteur_id' => $societeCivile->id],
            ['libelle' => 'ONG Agir pour le Développement', 'role' => 'Relais communautaire', 'groupe_acteur_id' => $societeCivile->id],
            ['libelle' => 'Fédération des BTP de Côte d\'Ivoire', 'role' => 'Entreprises exécutantes', 'groupe_acteur_id' => $secteurPrive->id],
            ['libelle' => 'Chambre de Commerce et d\'Industrie de Côte d\'Ivoire', 'role' => 'Appui au secteur privé', 'groupe_acteur_id' => $secteurPrive->id],
            ['libelle' => 'PNUD Côte d\'Ivoire', 'role' => 'Appui technique', 'groupe_acteur_id' => $ptf->id],
            ['libelle' => 'Ambassade de France en Côte d\'Ivoire', 'role' => 'Partenaire financier', 'groupe_acteur_id' => $ptf->id],
        ];
        foreach ($acteurs as $a) {
            Acteur::firstOrCreate(['libelle' => $a['libelle']], $a);
        }

        foreach (['France', 'Chine', 'Maroc', 'Allemagne', 'États-Unis', 'Japon'] as $pays) {
            PaysEtranger::firstOrCreate(['libelle' => $pays]);
        }

        foreach (['Rapport d\'activité', 'Étude de faisabilité', 'Convention de financement', 'Note technique', 'Plan de passation des marchés', 'Rapport d\'évaluation'] as $libelle) {
            TypeDocument::firstOrCreate(['libelle' => $libelle]);
        }

        $actions = [
            ['libelle' => 'Renforcer les infrastructures de transport', 'description' => 'Développer le réseau routier, portuaire et aéroportuaire national.'],
            ['libelle' => "Améliorer l'accès à l'électricité", 'description' => 'Étendre la couverture électrique en zones urbaines et rurales.'],
            ['libelle' => "Développer l'éducation technique et professionnelle", 'description' => "Renforcer l'offre de formation qualifiante adaptée au marché de l'emploi."],
            ['libelle' => "Moderniser l'administration publique", 'description' => 'Numériser les services publics et améliorer leur efficacité.'],
            ['libelle' => "Promouvoir l'inclusion financière", 'description' => 'Faciliter l\'accès aux services financiers pour les populations et les PME.'],
        ];
        foreach ($actions as $a) {
            ActionPnd::firstOrCreate(['libelle' => $a['libelle']], $a);
        }
    }

    /* ------------------------------------------------------------------ */
    /* 2. Axes (par programme) et réformes                                 */
    /* ------------------------------------------------------------------ */
    private function axesEtReformes(): void
    {
        foreach (Programme::all() as $programme) {
            Axe::firstOrCreate(['libelle' => 'Axe 1 - '.$programme->nom, 'programme_id' => $programme->id]);
            Axe::firstOrCreate(['libelle' => 'Axe 2 - '.$programme->nom, 'programme_id' => $programme->id]);
        }

        // Rattache environ un tiers des projets existants à un axe de leur secteur,
        // pour que la page "Projets rattachés" d'un programme via ses axes soit peuplée.
        $axes = Axe::all();
        if ($axes->isNotEmpty()) {
            Projet::orderBy('id')->get()->each(function ($projet, $i) use ($axes) {
                if ($i % 3 === 0) {
                    $projet->update(['axe_id' => $axes[$i % $axes->count()]->id]);
                }
            });
        }

        $structures = Structure::inRandomOrder()->take(5)->get();
        $reformes = [
            ['libelle' => 'Réforme du cadre de passation des marchés publics', 'statut' => 'en_cours', 'annee_debut' => 2024, 'annee_fin' => 2027],
            ['libelle' => 'Digitalisation des services du Ministère du Plan', 'statut' => 'en_cours', 'annee_debut' => 2025, 'annee_fin' => 2026],
            ['libelle' => 'Réforme de la fiscalité locale', 'statut' => 'demarree', 'annee_debut' => 2026, 'annee_fin' => 2028],
            ['libelle' => 'Modernisation du cadastre national', 'statut' => 'demarree', 'annee_debut' => 2026, 'annee_fin' => 2029],
            ['libelle' => 'Renforcement du contrôle budgétaire', 'statut' => 'achevee', 'annee_debut' => 2023, 'annee_fin' => 2025],
        ];
        foreach ($reformes as $i => $r) {
            $structure = $structures[$i % max($structures->count(), 1)] ?? Structure::first();
            if (!$structure) {
                continue;
            }
            Reforme::firstOrCreate(['libelle' => $r['libelle']], array_merge($r, [
                'resultat_global_attendu' => 'Amélioration mesurable de la performance publique dans le domaine concerné.',
                'structure_id' => $structure->id,
                'axe_id' => $axes->isNotEmpty() ? $axes[$i % $axes->count()]->id : null,
            ]));
        }
    }

    /* ------------------------------------------------------------------ */
    /* 3. Données rattachées à chacun des projets existants                */
    /* ------------------------------------------------------------------ */
    private function parProjet(): void
    {
        $typesPartiePrenante = TypePartiePrenante::pluck('id')->all();
        $acteurs = Acteur::pluck('id')->all();
        $typesDocument = TypeDocument::pluck('id')->all();
        $typesAnalyseCausale = TypeAnalyseCausale::pluck('id')->all();
        $actionsPnd = ActionPnd::pluck('id')->all();
        $utilisateurs = User::pluck('id')->all();

        $milieux = ['rural', 'urbain', 'peri_urbain', 'inter_urbain'];

        Projet::with('financements')->orderBy('id')->each(function (Projet $projet, int $i) use (
            $typesPartiePrenante, $acteurs, $typesDocument, $typesAnalyseCausale, $actionsPnd,
            $utilisateurs, $milieux
        ) {
            $cout = (float) $projet->cout_estimatif;
            $anneeFin = $projet->date_fin?->year ?? 2027;

            // Action PND (RG40 : un projet n'est rattaché qu'à une seule action).
            if ($actionsPnd && !$projet->action_pnd_id) {
                $projet->update(['action_pnd_id' => $actionsPnd[$i % count($actionsPnd)]]);
            }

            // Composantes (2 par projet).
            foreach (['Volet travaux', 'Volet accompagnement'] as $j => $libelle) {
                Composante::create([
                    'libelle' => $libelle,
                    'budget_previsionnel' => round($cout * ($j === 0 ? 0.8 : 0.2), 2),
                    'projet_id' => $projet->id,
                ]);
            }

            // Risque.
            Risque::create([
                'libelle' => 'Retard de mobilisation des financements',
                'consequence' => 'Report du calendrier d\'exécution du projet.',
                'probabilite' => ['faible', 'moyenne', 'forte'][$i % 3],
                'impact' => ['faible', 'moyenne', 'elevee'][$i % 3],
                'mesure_mitigation' => 'Suivi rapproché des décaissements et relance régulière des bailleurs.',
                'projet_id' => $projet->id,
            ]);

            // Parties prenantes (2 par projet).
            foreach ([0, 1] as $k) {
                PartiePrenante::create([
                    'libelle' => $k === 0 ? 'Populations bénéficiaires' : 'Structure exécutante',
                    'sig' => $k === 0 ? 'POP' : 'EXEC',
                    'type_partie_prenante_id' => $typesPartiePrenante ? $typesPartiePrenante[($i + $k) % count($typesPartiePrenante)] : null,
                    'projet_id' => $projet->id,
                ]);
            }

            // Étude.
            Etude::create([
                'libelle' => 'Étude de faisabilité technique et financière',
                'mode_execution' => 'Marché public',
                'structure_realisation' => 'Bureau d\'études spécialisé',
                'budget' => round($cout * 0.01, 2),
                'date_demarrage' => $projet->date_debut,
                'duree' => '3 mois',
                'etat_execution' => $projet->statut === 'planifie' ? 'en_cours' : 'achevee',
                'projet_id' => $projet->id,
            ]);

            // Objectif spécifique (+ résultat attendu).
            $objectif = ObjectifSpecifique::create([
                'libelle' => 'Améliorer durablement le service rendu à la population',
                'description' => 'Objectif principal poursuivi par la mise en œuvre du projet.',
                'projet_id' => $projet->id,
            ]);
            ResultatAttendu::create([
                'niveau' => 'extrant',
                'produit' => 'Ouvrage livré et fonctionnel',
                'libelle' => 'Infrastructure réalisée et mise en service',
                'situation_reference' => '0',
                'cible' => '100%',
                'valeur_realisee' => $projet->avancement_physique.'%',
                'reste_a_atteindre' => max(0, 100 - $projet->avancement_physique).'%',
                'objectif_specifique_id' => $objectif->id,
            ]);

            // Milieu d'exécution.
            MilieuExecution::create([
                'categorie' => $milieux[$i % count($milieux)],
                'projet_id' => $projet->id,
            ]);

            // Document.
            Document::create([
                'projet_id' => $projet->id,
                'type_document_id' => $typesDocument ? $typesDocument[$i % count($typesDocument)] : null,
                'titre' => 'Rapport de présentation du projet',
                'source' => 'Structure porteuse',
                'strategie' => 'Diffusion interne',
                'type' => 'PDF',
                'fichier' => 'documents/projet-'.$projet->id.'-presentation.pdf',
                'description' => 'Document de présentation générale du projet.',
                'ajoute_par_id' => $utilisateurs ? $utilisateurs[$i % count($utilisateurs)] : null,
            ]);

            // Analyse causale.
            AnalyseCausale::create([
                'libelle' => 'Insuffisance des infrastructures existantes',
                'probleme_identifie' => 'Insuffisance des infrastructures existantes',
                'cause' => 'Sous-investissement et vétusté des équipements',
                'effet' => 'Accès limité des populations aux services de base',
                'projet_id' => $projet->id,
            ]);

            // Convention de financement (sur le financement déjà créé par ProjetDemoSeeder).
            $financement = $projet->financements->first();
            if ($financement) {
                ConventionFinancement::firstOrCreate(['financement_id' => $financement->id], [
                    'type_accord' => 'Accord de financement',
                    'nature_financement' => $financement->type_source ?? 'Prêt concessionnel',
                    'date_limite_tirage' => $projet->date_fin,
                    'niveau_avancement_negociations' => 'Accord signé',
                    'numero_accord_signe' => 'CONV-'.str_pad((string) $projet->id, 4, '0', STR_PAD_LEFT),
                    'montant' => $financement->montant_engage,
                    'date_signature' => $projet->date_debut,
                ]);
            }

            // Acteurs rattachés (2 par projet).
            if ($acteurs) {
                $projet->acteurs()->syncWithoutDetaching([
                    $acteurs[$i % count($acteurs)],
                    $acteurs[($i + 1) % count($acteurs)],
                ]);
            }
        });
    }
}
