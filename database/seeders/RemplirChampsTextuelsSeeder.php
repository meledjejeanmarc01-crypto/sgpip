<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Remplit automatiquement, sur TOUTES les tables de l'application, les colonnes
// textuelles optionnelles (description, observations, contexte, etc.) laissées
// vides, en s'appuyant sur le libellé/nom de la ligne elle-même quand il existe.
//
// Volontairement PRUDENT : ne touche jamais aux colonnes qui ne sont pas dans la
// liste blanche ci-dessous (donc jamais un email, un téléphone, un numéro de
// compte, une date, un montant, une clé étrangère ou un champ obligatoire) —
// on ne fabrique pas de fausses données sensibles ou identifiantes.
//
// Complète RemplirChampsVidesSeeder (spécifique aux projets, plus riche) pour
// toutes les autres entités : Bailleurs, Structures, Rapports, Documents,
// Réformes, Acteurs, Parties prenantes, Financements, Marchés, Études, etc.
//
// Rejouable sans risque : ne modifie que ce qui est encore NULL ou vide.
// php artisan db:seed --class=RemplirChampsTextuelsSeeder
class RemplirChampsTextuelsSeeder extends Seeder
{
    // Motifs de nom de colonne considérés comme "texte libre optionnel" sûrs à remplir.
    private array $motifsAutorises = [
        'description', 'observation', 'commentaire', 'remarque', 'note',
        'contexte', 'objectif', 'detail', 'contenu', 'resume', 'synthese',
        'impact', 'justification', 'conclusion', 'recommandation', 'commentaires',
        'precision', 'complement',
    ];

    // Tables système à ne jamais toucher.
    private array $tablesExclues = [
        'migrations', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches',
        'failed_jobs', 'password_reset_tokens', 'personal_access_tokens', 'users',
    ];

    public function run(): void
    {
        $colonnes = DB::select("
            SELECT TABLE_NAME, COLUMN_NAME
            FROM information_schema.columns
            WHERE TABLE_SCHEMA = DATABASE()
              AND IS_NULLABLE = 'YES'
              AND DATA_TYPE IN ('varchar', 'text', 'tinytext', 'mediumtext', 'longtext')
        ");

        $nbLignesModifiees = 0;
        $nbColonnesTraitees = 0;

        foreach ($colonnes as $c) {
            $table = $c->TABLE_NAME;
            $colonne = $c->COLUMN_NAME;

            if (in_array($table, $this->tablesExclues, true)) {
                continue;
            }

            $estAutorise = false;
            foreach ($this->motifsAutorises as $motif) {
                if (str_contains($colonne, $motif)) {
                    $estAutorise = true;
                    break;
                }
            }
            if (! $estAutorise) {
                continue;
            }

            // Colonne "identifiante" de la table (pour construire une phrase utile), si elle existe.
            $colonneLibelle = collect(['libelle', 'nom', 'intitule', 'titre', 'reference', 'numero'])
                ->first(fn ($nom) => \Illuminate\Support\Facades\Schema::hasColumn($table, $nom));

            $selectCols = $colonneLibelle ? "id, `{$colonne}`, `{$colonneLibelle}`" : "id, `{$colonne}`";

            $lignes = DB::table($table)
                ->select(DB::raw($selectCols))
                ->where(function ($q) use ($colonne) {
                    $q->whereNull($colonne)->orWhere($colonne, '');
                })
                ->get();

            if ($lignes->isEmpty()) {
                continue;
            }
            $nbColonnesTraitees++;

            $libelleHumain = str_replace('_', ' ', $colonne);

            foreach ($lignes as $ligne) {
                $sujet = $colonneLibelle ? ($ligne->{$colonneLibelle} ?? null) : null;

                $texte = $sujet
                    ? "Aucune {$libelleHumain} particulière renseignée pour « {$sujet} » à ce jour."
                    : "Aucune {$libelleHumain} particulière renseignée à ce jour.";

                DB::table($table)->where('id', $ligne->id)->update([$colonne => $texte]);
                $nbLignesModifiees++;
            }
        }

        $this->command?->info("Colonnes textuelles traitées : {$nbColonnesTraitees}");
        $this->command?->info("Lignes complétées : {$nbLignesModifiees}");
    }
}
