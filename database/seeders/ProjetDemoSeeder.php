<?php

namespace Database\Seeders;

use App\Models\Activite;
use App\Models\Bailleur;
use App\Models\Decaissement;
use App\Models\Depense;
use App\Models\Etat;
use App\Models\FichePip;
use App\Models\Financement;
use App\Models\Indicateur;
use App\Models\PieceJustificative;
use App\Models\Projet;
use App\Models\Rapport;
use App\Models\Secteur;
use App\Models\Structure;
use App\Models\Tache;
use App\Models\User;
use App\Models\ZoneLocalisation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjetDemoSeeder extends Seeder
{
    /**
     * 62 exemples de projets extraits du PIP régional 2026-2030 (fiches techniques
     * perspectives par région / commune), répartis sur les secteurs réels du PIP.
     */
    private array $items = [
            ['secteur' => 'Infrastructures', 'zone' => 'Moronou', 'intitule' => 'Aménager et bitumer la route M\'Batto-Afféry (40 km)'],
            ['secteur' => 'Infrastructures', 'zone' => 'Kabadougou', 'intitule' => 'Aménager et bitumer la route Tiémé- N\'Globlasso - Goulia (57km)'],
            ['secteur' => 'Transport', 'zone' => 'Songon', 'intitule' => 'Construire des parkings publics et souterrains dans les zones commerciales et administratives'],
            ['secteur' => 'Transport', 'zone' => 'Yopougon', 'intitule' => 'Développer un réseau cyclable sécurisé et des pistes piétonnes'],
            ['secteur' => 'Transition Numérique', 'zone' => 'Gbêkê', 'intitule' => 'Construire 12 sites radioélectriques à Andobo-Alluibo, Assekakro, Besseri-Takikro, Bobokro, Djigbe, Fari-Oko, Iki, Kirakro, Koyorabo, Monebo, Plahankro, Zédé-Kan'],
            ['secteur' => 'Transition Numérique', 'zone' => 'Treichville', 'intitule' => 'Poursuivre la digitalisation du processus d\'obtention des extraits de casier judiciaire, des certificats de nationalité et autres documents administratifs'],
            ['secteur' => 'Industrie', 'zone' => 'Tonkpi', 'intitule' => 'Etendre le parc de zones d\'activité industrielle'],
            ['secteur' => 'Industrie', 'zone' => 'Grands-Ponts', 'intitule' => 'Aménager la zone industrielle de Dabou'],
            ['secteur' => 'Commerce', 'zone' => 'Moronou', 'intitule' => 'Construire des marchés de proximité'],
            ['secteur' => 'Commerce', 'zone' => 'Marahoué', 'intitule' => 'Créer une unité Satellite de transformation de noix de cajou (1500T) à Zuénoula'],
            ['secteur' => 'Artisanat', 'zone' => 'Gbôklé', 'intitule' => 'Promouvoir des activités artisanales à travers l\'appui logistique aux associations locales et la valorisation des savoir-faire traditionnels'],
            ['secteur' => 'Artisanat', 'zone' => 'Gbôklé', 'intitule' => 'Poursuivre la formation de 500 artisans'],
            ['secteur' => 'Promotion des PME', 'zone' => 'Gôh', 'intitule' => 'Mettre en œuvre le projet Clonix PHASE-II'],
            ['secteur' => 'Promotion des PME', 'zone' => 'Attécoubé', 'intitule' => 'Mettre en place des microcrédits et programmes d\'accompagnement financier pour jeunes et femmes entrepreneures'],
            ['secteur' => 'Sport', 'zone' => 'La Mé', 'intitule' => 'Construire une salle de sport semi-couverte au Lycée Moderne d\'Adzopé et d\'Alépé'],
            ['secteur' => 'Sport', 'zone' => 'District Autonome d\'Abidjan', 'intitule' => 'Construire deux (02) salles de sports sémi-couverte dans le Lycée Moderne Koumassi 2 et le Lycée Moderne de Treichville'],
            ['secteur' => 'Femme, Famille et Enfant', 'zone' => 'Port-Bouët', 'intitule' => 'Promouvoir l\'autonomisation économique des femmes par la formation et le microcrédit'],
            ['secteur' => 'Femme, Famille et Enfant', 'zone' => 'Bagoué', 'intitule' => 'Réhabiliter et équiper l\'IFEF de Boundiali'],
            ['secteur' => 'Justice et Droits de l\'Homme', 'zone' => 'Haut-Sassandra', 'intitule' => 'Construire et équiper le tribunal du commerce de Daloa'],
            ['secteur' => 'Justice et Droits de l\'Homme', 'zone' => 'District Autonome d\'Abidjan', 'intitule' => 'Construire et équiper une nouvelle MAC et sa cité pénitentiaire à Bingerville'],
            ['secteur' => 'Hydraulique', 'zone' => 'District Autonome d\'Abidjan', 'intitule' => 'Alimenter la zone sud d\'Abidjan à partir de la nappe du Sud Comoé - phase 3'],
            ['secteur' => 'Hydraulique', 'zone' => 'Bagoué', 'intitule' => 'Mettre en œuvre un programme d\'accès à l\'eau dans les écoles et centres de santé'],
            ['secteur' => 'Éducation', 'zone' => 'Bafing', 'intitule' => 'Construire deux-cent cinquante (250) cantines scolaires dans deux-cent cinquante (250) gros villages de la région'],
            ['secteur' => 'Éducation', 'zone' => 'Moronou', 'intitule' => 'Construire et équiper 12 collèges sur la période 2026-2028'],
            ['secteur' => 'Enseignement Supérieur et Recherche Scientifique', 'zone' => 'District Autonome d\'Abidjan', 'intitule' => 'Poursuivre la réhabilitation et équipement Centre Recherches Océanographiques (CRO)'],
            ['secteur' => 'Enseignement Supérieur et Recherche Scientifique', 'zone' => 'Tonkpi', 'intitule' => 'Étendre les infrastructures de l\'Université de Man'],
            ['secteur' => 'Enseignement Technique et Formation Professionnelle', 'zone' => 'Haut-Sassandra', 'intitule' => 'Construire et équiper le garage école de Daloa'],
            ['secteur' => 'Enseignement Technique et Formation Professionnelle', 'zone' => 'Agnéby-Tiassa', 'intitule' => 'Construire un lycée professionnel agricole à Sahué sous-préfecture de Sikensi'],
            ['secteur' => 'Tourisme et Loisirs', 'zone' => 'District Autonome d\'Abidjan', 'intitule' => 'Construire deux (2) villages d\'artisans'],
            ['secteur' => 'Tourisme et Loisirs', 'zone' => 'Port-Bouët', 'intitule' => 'Développer l\'écotourisme côtier (plages, mangroves, excursions lagunaires)'],
            ['secteur' => 'Agriculture', 'zone' => 'Gontougo', 'intitule' => 'Mettre en œuvre le projet de pôle agro-industriel dans le nord-est de la Côte d\'Ivoire'],
            ['secteur' => 'Agriculture', 'zone' => 'Haut-Sassandra', 'intitule' => 'Créer des unités de transformation de manioc'],
            ['secteur' => 'Ressources Animales et Halieutiques', 'zone' => 'District Autonome de Yamoussoukro', 'intitule' => 'Créer des points de vente des produits issus des élevages en développement'],
            ['secteur' => 'Ressources Animales et Halieutiques', 'zone' => 'San-Pédro', 'intitule' => 'Installer 6 fermes aquacoles'],
            ['secteur' => 'Habitat et Logement', 'zone' => 'Gbôklé', 'intitule' => 'Aménager et meubler le siège du Conseil régional et la résidence du directeur général de l\'administration'],
            ['secteur' => 'Habitat et Logement', 'zone' => 'District Autonome d\'Abidjan', 'intitule' => 'Restructurer et aménager les quartiers précaires d\'Abidjan'],
            ['secteur' => 'Assainissement et Salubrité', 'zone' => 'Haut-Sassandra', 'intitule' => 'Poursuivre la dotation des communes ne disposant pas de service délégué de propreté en matériel de salubrité'],
            ['secteur' => 'Assainissement et Salubrité', 'zone' => 'Marahoué', 'intitule' => 'Construire un (01) Centre de Valorisation et d\'Enfouissement Technique à Bonon'],
            ['secteur' => 'Santé', 'zone' => 'San-Pédro', 'intitule' => 'Construire 45 ESPC dont 14 dispensaires ruraux, 21 centres de santé urbains et 10 centres de santé ruraux'],
            ['secteur' => 'Santé', 'zone' => 'Agnéby-Tiassa', 'intitule' => 'Renforcer la production d\'oxygène dans les établissements sanitaires de référence'],
            ['secteur' => 'Mines', 'zone' => 'Worodougou', 'intitule' => 'Poursuivre la construction de la mine d\'or KONÉ, dans les départements de Kani'],
            ['secteur' => 'Mines', 'zone' => 'Bagoué', 'intitule' => 'Poursuivre le projet minier aurifère avancé de la Bagoué (phase de développement)'],
            ['secteur' => 'Électricité', 'zone' => 'Poro', 'intitule' => 'Mettre en œuvre le Projet de réalisation de la centrale solaire de Binguebougou (50 MWC)'],
            ['secteur' => 'Électricité', 'zone' => 'Gôh', 'intitule' => 'Mettre en œuvre le Programme Électricité Pour Tous (PEPT) par le branchement de 400 000 ménages au niveau national dont la région du Gôh'],
            ['secteur' => 'Culture', 'zone' => 'Abobo', 'intitule' => 'Promouvoir les arts, traditions et savoir-faire locaux (danse, artisanat, musique)'],
            ['secteur' => 'Culture', 'zone' => 'Bingerville', 'intitule' => 'Développer des infrastructures touristiques (hébergements, routes d\'accès, signalétique)'],
            ['secteur' => 'Gouvernance Locale', 'zone' => 'Adjamé', 'intitule' => 'Mettre en place un système de suivi-évaluation pour le suivi des projets et leur impact socio-économique'],
            ['secteur' => 'Gouvernance Locale', 'zone' => 'San-Pédro', 'intitule' => 'Construire et équiper un centre régional d\'archives'],
            ['secteur' => 'Emploi et Protection Sociale', 'zone' => 'Adjamé', 'intitule' => 'Réhabiliter et équiper les services de l\'administration du travail d\'Adjamé'],
            ['secteur' => 'Emploi et Protection Sociale', 'zone' => 'Gbêkê', 'intitule' => 'Poursuivre l\'enrôlement au RSTI et à la CMU'],
            ['secteur' => 'Genre et Égalité des Sexes', 'zone' => 'Agnéby-Tiassa', 'intitule' => 'Aménager et équiper des Crèches garderies dans les CPPE des régions non pourvues dont l\'Agnéby-Tiassa'],
            ['secteur' => 'Genre et Égalité des Sexes', 'zone' => 'Agnéby-Tiassa', 'intitule' => 'Construire et équiper des CACE dans les sous-préfectures de la région de l\'Agnéby-Tiassa'],
            ['secteur' => 'Infrastructures Routières', 'zone' => 'Gbêkê', 'intitule' => 'Acquérir un bac pour la traversée à Béoumi'],
            ['secteur' => 'Infrastructures Routières', 'zone' => 'Gbôklé', 'intitule' => 'Construire et renforcer les routes (reprofilage lourd et léger) et ouvrages'],
            ['secteur' => 'Défense et Sécurité', 'zone' => 'Iffou', 'intitule' => 'Construire une caserne de sapeurs-pompiers'],
            ['secteur' => 'Défense et Sécurité', 'zone' => 'Kabadougou', 'intitule' => 'Construire et équiper des centres de manœuvres et d\'entrainements'],
            ['secteur' => 'Protection Civile', 'zone' => 'Koumassi', 'intitule' => 'Développer une brigade municipale de prévention (sécurité routière, environnement)'],
            ['secteur' => 'Protection Civile', 'zone' => 'Port-Bouët', 'intitule' => 'Renforcer la vidéosurveillance et la présence policière dans les zones sensibles'],
            ['secteur' => 'Jeunesse', 'zone' => 'Tonkpi', 'intitule' => 'Insertion de 27 458 jeunes aux programmes d\'insertion professionnelle (2023 -2025)'],
            ['secteur' => 'Jeunesse', 'zone' => 'Tchologo', 'intitule' => 'Construire et équiper 12 Agences (une dans chacune des Sous-Préfectures) types de l\'agence emploi jeunes dans la région'],
            ['secteur' => 'Environnement', 'zone' => 'Marcory', 'intitule' => 'Promouvoir l\'énergie renouvelable (solaire sur bâtiments publics et éclairage public)'],
            ['secteur' => 'Environnement', 'zone' => 'Cocody', 'intitule' => 'Mettre en place des centres de traitement des eaux usées et de lutte contre les inondations'],
            ['secteur' => 'Enseignement Technique et Formation Professionnelle', 'zone' => 'Bélier', 'intitule' => 'Construire le Lycée Professionnel de Toumodi'],
            ['secteur' => 'Infrastructures Routières', 'zone' => 'Béré', 'intitule' => 'Aménager et bitumer la route Séguéla-Kongasso-Kounahiri (100 km)'],
            ['secteur' => 'Éducation', 'zone' => 'Bounkani', 'intitule' => 'Poursuivre la construction du Lycée d\'Excellence de jeunes filles de Bouna'],
            ['secteur' => 'Commerce', 'zone' => 'Cavally', 'intitule' => 'Reconstruire aux normes le marché de détail de Guiglo'],
            ['secteur' => 'Infrastructures', 'zone' => 'Folon', 'intitule' => 'Construire le pont sur l\'axe Banankoro - Manadoun'],
            ['secteur' => 'Infrastructures Routières', 'zone' => 'Guémon', 'intitule' => 'Aménager et bitumer la route Guéhiebly - Zou - Mahapleu (91 km)'],
            ['secteur' => 'Santé', 'zone' => 'Hambol', 'intitule' => 'Poursuivre la construction et l\'équipement du CHR de Katiola'],
            ['secteur' => 'Enseignement Supérieur et Recherche Scientifique', 'zone' => 'Indénié-Djuablin', 'intitule' => 'Construire l\'Université d\'Abengourou'],
            ['secteur' => 'Commerce', 'zone' => 'Lôh-Djiboua', 'intitule' => 'Poursuivre la construction de dix (10) marchés dans le Lôh-Djiboua'],
            ['secteur' => 'Électricité', 'zone' => 'Nawa', 'intitule' => 'Poursuivre les travaux de réhabilitation du groupe 3 de la centrale hydroélectrique de Buyo'],
            ['secteur' => 'Enseignement Technique et Formation Professionnelle', 'zone' => 'Nzi', 'intitule' => 'Construire le Lycée Professionnel de Dimbokro'],
            ['secteur' => 'Transport', 'zone' => 'Le Plateau', 'intitule' => 'Finaliser la construction des infrastructures et mettre en service le métro d\'Abidjan'],
            ['secteur' => 'Électricité', 'zone' => 'Sud-Comoé', 'intitule' => 'Finaliser la construction de la centrale à biomasse BIOVEA à Aboisso'],
    ];

    /** Correspondance secteur du PIP -> sigle de la structure (ministère) responsable */
    private array $secteurStructure = [
            'Infrastructures' => 'MIE',
            'Infrastructures Routières' => 'MIE',
            'Transport' => 'MT',
            'Transition Numérique' => 'MTND',
            'Industrie' => 'MCIPME',
            'Commerce' => 'MCIPME',
            'Artisanat' => 'MCIPME',
            'Promotion des PME' => 'MCIPME',
            'Sport' => 'MSPT',
            'Femme, Famille et Enfant' => 'MFFE',
            'Genre et Égalité des Sexes' => 'MFFE',
            'Justice et Droits de l\'Homme' => 'MJDH',
            'Hydraulique' => 'MH',
            'Assainissement et Salubrité' => 'MASU',
            'Éducation' => 'MENA',
            'Enseignement Supérieur et Recherche Scientifique' => 'MESRS',
            'Enseignement Technique et Formation Professionnelle' => 'METFPA',
            'Tourisme et Loisirs' => 'MTL',
            'Agriculture' => 'MADR',
            'Ressources Animales et Halieutiques' => 'MIRAH',
            'Habitat et Logement' => 'MCLU',
            'Santé' => 'MSHPCMU',
            'Mines' => 'MMPE',
            'Électricité' => 'MMPE',
            'Culture' => 'MCF',
            'Gouvernance Locale' => 'MATD',
            'Emploi et Protection Sociale' => 'MEPS',
            'Défense et Sécurité' => 'MDEF',
            'Protection Civile' => 'MIS',
            'Jeunesse' => 'MPJ',
            'Environnement' => 'MINEDD',
    ];

    public function run(): void
    {
        $bailleurs = Bailleur::orderBy('id')->get();
        $etat = Etat::first();
        $gestionnaire = User::where('email', 'i.gbane@plan.gouv.ci')->first();
        $financier = User::where('email', 'i.diarra@plan.gouv.ci')->first();
        $suivi = User::where('email', 'i.yapo@plan.gouv.ci')->first();

        $fichePipInfra = FichePip::where('numero', 'PIP-2026-0001')->first();
        $fichePipEducation = FichePip::where('numero', 'PIP-2026-0002')->first();
        $fichePipSante = FichePip::where('numero', 'PIP-2026-0003')->first();

        $statutsCycle = ['en_cours', 'planifie', 'termine', 'retarde', 'en_cours', 'suspendu', 'en_cours', 'planifie', 'termine', 'en_cours'];
        $typesRapport = ['trimestriel', 'avancement', 'financier', 'suivi'];
        $categoriesPiece = ['facture', 'contrat', 'proces_verbal'];

        foreach ($this->items as $i => $item) {
            $secteur = Secteur::where('libelle', $item['secteur'])->first();
            $zone = ZoneLocalisation::where('libelle', $item['zone'])->first();
            $sigleStructure = $this->secteurStructure[$item['secteur']] ?? 'MIE';
            $structure = Structure::where('sigle', $sigleStructure)->first();

            if (!$secteur || !$zone || !$structure) {
                continue;
            }

            $statut = $statutsCycle[$i % count($statutsCycle)];

            // Dates et avancement cohérents avec le statut (aujourd'hui : sept. 2026)
            switch ($statut) {
                case 'planifie':
                    $dateDebut = Carbon::create(2027, 1, 1)->addDays($i * 3);
                    $dateFin = (clone $dateDebut)->addMonths(18);
                    $avancement = 0;
                    break;
                case 'termine':
                    $dateDebut = Carbon::create(2023, 2, 1)->addDays($i * 5);
                    $dateFin = (clone $dateDebut)->addMonths(20);
                    $avancement = 100;
                    break;
                case 'retarde':
                    $dateDebut = Carbon::create(2024, 2, 1)->addDays($i * 4);
                    $dateFin = (clone $dateDebut)->addMonths(15);
                    $avancement = 15 + ($i % 4) * 5;
                    break;
                case 'suspendu':
                    $dateDebut = Carbon::create(2024, 6, 1)->addDays($i * 4);
                    $dateFin = (clone $dateDebut)->addMonths(20);
                    $avancement = 35 + ($i % 3) * 10;
                    break;
                default: // en_cours
                    $dateDebut = Carbon::create(2025, 3, 1)->addDays($i * 4);
                    $dateFin = (clone $dateDebut)->addMonths(24);
                    $avancement = 20 + ($i % 6) * 10;
                    break;
            }

            $cout = 250_000_000 + (($i * 173) % 33) * 200_000_000;

            $projet = Projet::create([
                'reference' => sprintf('PIP-CI-2026-%03d', $i + 1),
                'intitule' => Str::limit($item['intitule'], 250, ''),
                'contexte' => "Projet identifié dans le cadre du Programme d'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de {$item['zone']}.",
                'objectif' => "Contribuer au développement du secteur « {$item['secteur']} » dans la zone de {$item['zone']}, conformément aux orientations du PIP régional.",
                'cout_estimatif' => $cout,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'avancement_physique' => $avancement,
                'statut' => $statut,
                'structure_id' => $structure->id,
                'secteur_id' => $secteur->id,
                'zone_localisation_id' => $zone->id,
            ]);

            // Association ponctuelle à une fiche PIP existante, selon le secteur
            if ($fichePipInfra && str_contains($item['secteur'], 'Infrastructure')) {
                $projet->fichesPip()->syncWithoutDetaching([$fichePipInfra->id]);
            } elseif ($fichePipEducation && $item['secteur'] === 'Éducation') {
                $projet->fichesPip()->syncWithoutDetaching([$fichePipEducation->id]);
            } elseif ($fichePipSante && $item['secteur'] === 'Santé') {
                $projet->fichesPip()->syncWithoutDetaching([$fichePipSante->id]);
            }

            // --- Financement ---
            $montantEngage = (int) round($cout * 0.9);
            $financementData = [
                'reference' => sprintf('FIN-2026-%03d', $i + 1),
                'montant_engage' => $montantEngage,
                'date' => $dateDebut,
                'projet_id' => $projet->id,
            ];
            if ($i % 3 === 0 || $bailleurs->isEmpty()) {
                $financementData['etat_id'] = $etat?->id;
            } else {
                $financementData['bailleur_id'] = $bailleurs[$i % $bailleurs->count()]->id;
            }
            $financement = Financement::create($financementData);

            // --- Décaissement (sauf pour les projets simplement planifiés) ---
            $depense = null;
            if ($statut !== 'planifie') {
                $montantDecaisse = (int) round($montantEngage * ($avancement / 100) * 0.95);
                $bailleurDecaissement = $financementData['bailleur_id'] ?? optional($bailleurs->first())->id;
                if ($bailleurDecaissement) {
                    Decaissement::create([
                        'reference' => sprintf('DEC-2026-%03d', $i + 1),
                        'montant' => max($montantDecaisse, 1_000_000),
                        'date' => (clone $dateDebut)->addMonths(2),
                        'bailleur_id' => $bailleurDecaissement,
                        'financement_id' => $financement->id,
                    ]);
                }

                // --- Dépense ---
                $depense = Depense::create([
                    'reference' => sprintf('DEP-2026-%03d', $i + 1),
                    'libelle' => 'Travaux et acquisitions - '.Str::limit($item['intitule'], 80, ''),
                    'montant' => (int) round($montantEngage * 0.55),
                    'date' => (clone $dateDebut)->addMonths(3),
                    'projet_id' => $projet->id,
                ]);
            }

            // --- Activités, tâches, indicateurs ---
            $nbActivites = ($i % 2 === 0) ? 2 : 1;
            $phases = ['Études et mobilisation des ressources', 'Exécution des travaux et acquisitions'];
            for ($a = 0; $a < $nbActivites; $a++) {
                $tauxActivite = $a === 0
                    ? min(100, $avancement + 20)
                    : max(0, $avancement - 20);

                $activite = Activite::create([
                    'intitule' => 'Phase '.($a + 1).' : '.$phases[$a],
                    'date_debut' => (clone $dateDebut)->addMonths($a * 6),
                    'date_fin' => (clone $dateDebut)->addMonths($a * 6 + 8),
                    'taux_avancement' => $tauxActivite,
                    'projet_id' => $projet->id,
                ]);

                Tache::create([
                    'intitule' => $a === 0 ? 'Réalisation des études techniques' : 'Exécution et réception des travaux',
                    'description' => 'Tâche rattachée à : '.Str::limit($item['intitule'], 100, ''),
                    'date_debut' => $activite->date_debut,
                    'date_fin' => $activite->date_fin,
                    'activite_id' => $activite->id,
                    'depense_id' => ($a === 0) ? optional($depense)->id : null,
                ]);

                if ($a === 0) {
                    Tache::create([
                        'intitule' => 'Passation des marchés publics',
                        'description' => 'Sélection et contractualisation des entreprises pour : '.Str::limit($item['intitule'], 90, ''),
                        'date_debut' => $activite->date_debut,
                        'date_fin' => (clone $activite->date_debut)->addMonths(2),
                        'activite_id' => $activite->id,
                    ]);
                }

                Indicateur::create([
                    'nom' => $a === 0 ? 'Taux de réalisation des études (%)' : 'Taux de réalisation physique des travaux (%)',
                    'unite' => '%',
                    'valeur_cible' => 100,
                    'valeur_realisee' => $tauxActivite,
                    'date_mesure' => (clone $dateDebut)->addMonths($a * 6 + 4),
                    'activite_id' => $activite->id,
                ]);
            }

            // --- Rapport de suivi (dès que le projet a démarré) ---
            if ($statut !== 'planifie' && $suivi && $gestionnaire && $financier) {
                $typeRapport = $typesRapport[$i % count($typesRapport)];
                $auteur = $typeRapport === 'financier' ? $financier : ($typeRapport === 'avancement' ? $gestionnaire : $suivi);

                Rapport::create([
                    'type' => $typeRapport,
                    'titre' => ucfirst($typeRapport).' - '.Str::limit($item['intitule'], 70, ''),
                    'donnees' => "Point de situation du projet « {$item['intitule']} » (zone : {$item['zone']}). Avancement physique estimé à {$avancement}%. Statut administratif : {$statut}.",
                    'fichier' => 'rapports/rapport-demo.pdf',
                    'date' => (clone $dateDebut)->addMonths(6),
                    'projet_id' => $projet->id,
                    'utilisateur_id' => $auteur->id,
                ]);
            }

            // --- Pièce justificative (projets ayant une activité financière) ---
            if ($statut !== 'planifie' && $financier) {
                PieceJustificative::create([
                    'fichier' => 'pieces-justificatives/piece-justificative-demo.pdf',
                    'categorie' => $categoriesPiece[$i % count($categoriesPiece)],
                    'libelle' => 'Pièce relative à : '.Str::limit($item['intitule'], 60, ''),
                    'projet_id' => $projet->id,
                    'utilisateur_id' => $financier->id,
                ]);
            }
        }
    }
}
