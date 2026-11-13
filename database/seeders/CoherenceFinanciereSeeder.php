<?php

namespace Database\Seeders;

use App\Models\Bailleur;
use App\Models\Decaissement;
use App\Models\Depense;
use App\Models\Financement;
use App\Models\Projet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Rend les montants cohérents dans chaque projet :
 *     montant financé > montant décaissé > montant dépensé
 *
 * - Un projet sans montant financé en reçoit un (90 % du coût estimatif).
 * - Les décaissements sont ramenés à un pourcentage du financé (selon l'avancement physique).
 * - Les dépenses sont ramenées à 80-92 % du décaissé.
 *
 * Lancer avec : php artisan db:seed --class=CoherenceFinanciereSeeder
 * Peut être relancé sans risque (résultat identique).
 */
class CoherenceFinanciereSeeder extends Seeder
{
    public function run(): void
    {
        $bailleurParDefaut = Bailleur::query()->value('id');
        $nbProjets = 0;

        DB::transaction(function () use ($bailleurParDefaut, &$nbProjets) {
            foreach (Projet::orderBy('id')->get() as $projet) {
                $avancement = (int) ($projet->avancement_physique ?? 0);
                $tauxDecaissement = min(0.92, max(0.08, ($avancement / 100) * 0.95));
                $tauxDepense = 0.80 + (($projet->id % 4) * 0.04);

                // 1. Montant financé : compléter si absent ou nul.
                $financements = Financement::where('projet_id', $projet->id)->orderBy('id')->get();
                if ((float) $financements->sum('montant_engage') <= 0) {
                    $cout = (float) ($projet->cout_estimatif ?? 0);
                    if ($cout <= 0) {
                        $cout = 500000000;
                    }
                    $montantFinance = round($cout * 0.9);

                    if ($financements->isNotEmpty()) {
                        $financements->first()->update(['montant_engage' => $montantFinance]);
                    } else {
                        Financement::create([
                            'reference' => 'FIN-AUTO-'.str_pad((string) $projet->id, 4, '0', STR_PAD_LEFT),
                            'montant_engage' => $montantFinance,
                            'date' => $projet->date_debut ?? now()->toDateString(),
                            'projet_id' => $projet->id,
                            'bailleur_id' => $bailleurParDefaut,
                        ]);
                    }
                    $financements = Financement::where('projet_id', $projet->id)->orderBy('id')->get();
                }

                // 2. Décaissements : même taux sur chaque financement du projet.
                $totalDecaisse = 0.0;
                foreach ($financements as $financement) {
                    $finance = (float) $financement->montant_engage;
                    if ($finance <= 0) {
                        continue;
                    }
                    $cible = round($finance * $tauxDecaissement);
                    $totalDecaisse += $cible;

                    $lignes = Decaissement::where('financement_id', $financement->id)->orderBy('id')->get();
                    if ($lignes->isEmpty()) {
                        $bailleurId = $financement->bailleur_id ?? $bailleurParDefaut;
                        if (! $bailleurId) {
                            $this->command?->warn("Projet {$projet->id} : aucun bailleur, décaissement non créé.");
                            continue;
                        }
                        Decaissement::create([
                            'reference' => 'DEC-AUTO-'.str_pad((string) $financement->id, 4, '0', STR_PAD_LEFT),
                            'montant' => $cible,
                            'date' => $financement->date ?? now()->toDateString(),
                            'bailleur_id' => $bailleurId,
                            'financement_id' => $financement->id,
                        ]);
                    } else {
                        $this->mettreALEchelle($lignes, $cible);
                    }
                }

                // 3. Dépenses : toujours inférieures au décaissé.
                $cibleDepense = floor($totalDecaisse * $tauxDepense);
                $depenses = Depense::where('projet_id', $projet->id)->orderBy('id')->get();
                if ($depenses->isEmpty()) {
                    Depense::create([
                        'reference' => 'DEP-AUTO-'.str_pad((string) $projet->id, 4, '0', STR_PAD_LEFT),
                        'libelle' => 'Dépenses du projet',
                        'montant' => $cibleDepense,
                        'date' => $projet->date_debut ?? now()->toDateString(),
                        'projet_id' => $projet->id,
                    ]);
                } else {
                    $this->mettreALEchelle($depenses, $cibleDepense);
                }

                $nbProjets++;
            }
        });

        $this->command?->info("Montants financés / décaissés / dépensés rendus cohérents pour {$nbProjets} projet(s).");
    }

    /**
     * Ajuste les montants des lignes pour que leur somme soit exactement $cible,
     * en conservant leurs proportions (la dernière ligne absorbe l'arrondi).
     */
    private function mettreALEchelle($lignes, float $cible): void
    {
        $cible = round($cible);
        $total = (float) $lignes->sum('montant');
        $reste = $cible;
        $nombre = $lignes->count();

        foreach ($lignes->values() as $rang => $ligne) {
            if ($rang === $nombre - 1) {
                $nouveau = $reste;
            } elseif ($total > 0) {
                $nouveau = round(((float) $ligne->montant) * $cible / $total);
            } else {
                $nouveau = $rang === 0 ? $cible : 0;
            }
            $nouveau = max(0, min($nouveau, $reste));
            $ligne->update(['montant' => $nouveau]);
            $reste -= $nouveau;
        }
    }
}
