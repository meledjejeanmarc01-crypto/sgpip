<?php

namespace Database\Seeders;

use App\Models\FichePip;
use App\Models\Programme;
use App\Models\Projet;
use App\Models\Secteur;
use App\Models\Structure;
use Illuminate\Database\Seeder;

// Relie chaque projet à un programme du PIP, en fonction de son secteur, en suivant
// le même schéma que les 3 programmes déjà enregistrés par ProgrammeFichePipSeeder :
// un secteur (ou un groupe de secteurs proches) -> un programme -> une fiche PIP -> les projets.
// Rejouable sans risque (firstOrCreate / syncWithoutDetaching, aucune suppression) :
// php artisan db:seed --class=ProgrammeSecteurSeeder
class ProgrammeSecteurSeeder extends Seeder
{
    // Secteur => infos.
    // Les 5 premières lignes réutilisent les 3 programmes déjà créés par ProgrammeFichePipSeeder
    // (le programme 1 couvre à la fois Infrastructures, Infrastructures Routières et Transport,
    // comme l'indique son nom "... Infrastructures et du Transport").
    // Les suivantes créent un programme + une fiche PIP par secteur restant.
    private array $mapping = [
        'Infrastructures' => ['code_existant' => 'PROG-2026-001'],
        'Infrastructures Routières' => ['code_existant' => 'PROG-2026-001'],
        'Transport' => ['code_existant' => 'PROG-2026-001'],
        'Éducation' => ['code_existant' => 'PROG-2026-002'],
        'Santé' => ['code_existant' => 'PROG-2026-003'],

        'Agriculture' => ['MADR', 'Programme National de Développement Agricole', 'PNDA 2026-2030'],
        'Artisanat' => ['MCIPME', "Programme de Promotion de l'Artisanat et des PME", 'PPAP 2026-2028'],
        'Assainissement et Salubrité' => ['MASU', "Programme National d'Assainissement et de Salubrité Urbaine", 'PNASU 2026-2030'],
        'Commerce' => ['MCIPME', 'Programme de Développement du Commerce Intérieur', 'PDCI 2026-2028'],
        'Culture' => ['MCF', 'Programme de Promotion de la Culture et de la Francophonie', 'PPCF 2026-2028'],
        'Défense et Sécurité' => ['MDEF', 'Programme de Renforcement des Capacités de Défense', 'PRCD 2026-2030'],
        'Emploi et Protection Sociale' => ['MEPS', "Programme National pour l'Emploi et la Protection Sociale", 'PNEPS 2026-2028'],
        'Enseignement Supérieur et Recherche Scientifique' => ['MESRS', "Programme de Renforcement de l'Enseignement Supérieur et de la Recherche", 'PRESR 2026-2029'],
        'Enseignement Technique et Formation Professionnelle' => ['METFPA', 'Programme de Développement de la Formation Professionnelle', 'PDFP 2026-2028'],
        'Environnement' => ['MINEDD', "Programme National de Développement Durable et d'Environnement", 'PNDDE 2026-2030'],
        'Femme, Famille et Enfant' => ['MFFE', "Programme de Promotion de la Femme, de la Famille et de l'Enfant", 'PPFFE 2026-2028'],
        'Genre et Égalité des Sexes' => ['MFFE', "Programme National pour l'Égalité des Sexes", 'PNES 2026-2028'],
        'Gouvernance Locale' => ['MATD', 'Programme de Renforcement de la Gouvernance Locale', 'PRGL 2026-2029'],
        'Habitat et Logement' => ['MCLU', "Programme National de l'Habitat et du Logement", 'PNHL 2026-2030'],
        'Hydraulique' => ['MH', 'Programme National Hydraulique', 'PNH 2026-2030'],
        'Industrie' => ['MCIPME', 'Programme de Développement Industriel', 'PDI 2026-2029'],
        'Jeunesse' => ['MPJ', 'Programme National de Promotion de la Jeunesse', 'PNPJ 2026-2028'],
        "Justice et Droits de l'Homme" => ['MJDH', 'Programme de Modernisation de la Justice', 'PMJ 2026-2029'],
        'Mines' => ['MMPE', 'Programme de Développement du Secteur Minier', 'PDSM 2026-2030'],
        'Promotion des PME' => ['MCIPME', 'Programme National de Promotion des PME', 'PNPPME 2026-2028'],
        'Protection Civile' => ['MIS', 'Programme de Renforcement de la Protection Civile', 'PRPC 2026-2029'],
        'Ressources Animales et Halieutiques' => ['MIRAH', 'Programme de Développement des Ressources Animales et Halieutiques', 'PDRAH 2026-2029'],
        'Sport' => ['MSPT', 'Programme National de Développement du Sport', 'PNDS 2026-2028'],
        'Tourisme et Loisirs' => ['MTL', 'Programme de Développement du Tourisme et des Loisirs', 'PDTL 2026-2029'],
        'Transition Numérique' => ['MTND', 'Programme National de Transition Numérique', 'PNTN 2026-2030'],
        'Électricité' => ['MMPE', "Programme National d'Accès à l'Électricité", 'PNAE 2026-2030'],
    ];

    public function run(): void
    {
        $numeroProgramme = 4; // PROG-2026-001 à 003 sont déjà pris par ProgrammeFichePipSeeder.
        $numeroFiche = 4;     // PIP-2026-0001 à 0003 idem.

        $fichesDejaCreees = []; // code programme => FichePip, pour ne créer qu'une fiche par programme.
        $secteursIgnores = [];
        $totalRelies = 0;

        foreach ($this->mapping as $libelleSecteur => $infos) {
            $secteur = Secteur::where('libelle', $libelleSecteur)->first();
            if (! $secteur) {
                $secteursIgnores[] = $libelleSecteur.' (secteur introuvable)';
                continue;
            }

            if (isset($infos['code_existant'])) {
                $programme = Programme::where('code', $infos['code_existant'])->first();
                $fichePip = $programme ? FichePip::where('programme_id', $programme->id)->first() : null;

                if (! $fichePip) {
                    $secteursIgnores[] = $libelleSecteur.' (programme/fiche existante introuvable, lancez d\'abord ProgrammeFichePipSeeder)';
                    continue;
                }
            } else {
                [$sigleStructure, $nomProgramme, $libelleProgramme] = $infos;
                $structure = Structure::where('sigle', $sigleStructure)->first();

                if (! $structure) {
                    $secteursIgnores[] = $libelleSecteur." (structure {$sigleStructure} introuvable)";
                    continue;
                }

                // Deux secteurs qui pointent vers la même structure ET le même nom de
                // programme partagent le même programme (ex. Commerce / Promotion des PME).
                $cleProgramme = $sigleStructure.'|'.$nomProgramme;

                if (! isset($fichesDejaCreees[$cleProgramme])) {
                    $anneeFin = preg_match('/(\d{4})$/', $libelleProgramme, $m) ? $m[1] : '2030';

                    $code = 'PROG-2026-'.str_pad((string) $numeroProgramme, 3, '0', STR_PAD_LEFT);
                    $programme = Programme::firstOrCreate(
                        ['code' => $code],
                        [
                            'nom' => $nomProgramme,
                            'libelle' => $libelleProgramme,
                            'date_debut' => '2026-01-01',
                            'date_fin' => "{$anneeFin}-12-31",
                            'structure_id' => $structure->id,
                        ]
                    );

                    $numeroFicheStr = 'PIP-2026-'.str_pad((string) $numeroFiche, 4, '0', STR_PAD_LEFT);
                    $fichePip = FichePip::firstOrCreate(
                        ['numero' => $numeroFicheStr],
                        ['nom' => "Fiche d'identification - {$libelleSecteur}", 'programme_id' => $programme->id]
                    );

                    $fichesDejaCreees[$cleProgramme] = $fichePip;
                    $numeroProgramme++;
                    $numeroFiche++;
                }

                $fichePip = $fichesDejaCreees[$cleProgramme];
            }

            // On relie tous les projets de ce secteur à la fiche PIP du programme,
            // sans jamais détacher une fiche déjà associée par ailleurs.
            $projets = Projet::where('secteur_id', $secteur->id)->get();
            foreach ($projets as $projet) {
                $projet->fichesPip()->syncWithoutDetaching([$fichePip->id]);
            }
            $totalRelies += $projets->count();
        }

        $this->command?->info("Projets reliés à un programme : {$totalRelies}");
        if ($secteursIgnores) {
            $this->command?->warn('Secteurs ignorés : '.implode(' | ', $secteursIgnores));
        }
    }
}
