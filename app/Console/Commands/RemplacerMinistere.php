<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Remplace « Ministère de l'Économie, du Plan et du Développement »
 * par « Ministère du Plan et du Développement » dans la base de données
 * et dans les fichiers générés (storage/app, public).
 *
 *   php artisan ministere:remplacer              -> simulation : liste ce qui serait modifié
 *   php artisan ministere:remplacer --appliquer  -> effectue le remplacement
 */
class RemplacerMinistere extends Command
{
    protected $signature = 'ministere:remplacer {--appliquer : Effectue le remplacement (sans cette option, simple simulation)}';

    protected $description = "Remplace l'ancien nom du ministère par « Ministère du Plan et du Développement » (base de données et fichiers générés)";

    // Détecte aussi : sans accent, apostrophe courbe, entités HTML, « Développent » mal écrit, majuscules.
    private const MOTIF = '/Minist(?:è|e|&egrave;|&#232;)re\s+de\s+l(?:\'|’|&rsquo;|&#0?39;|&apos;)?\s?(?:É|é|E|e|&Eacute;|&eacute;|&#201;|&#233;)conomie,?\s+du\s+Plan\s+et\s+du\s+D(?:é|e|É|&eacute;|&Eacute;|&#233;|&#201;)velopp(?:ement|ent)/iu';

    public function handle(): int
    {
        $appliquer = (bool) $this->option('appliquer');

        $this->info($appliquer
            ? 'MODE APPLICATION : les remplacements sont effectués.'
            : 'MODE SIMULATION : rien n\'est modifié (ajoutez --appliquer pour remplacer).');
        $this->newLine();

        $total = $this->baseDeDonnees($appliquer) + $this->fichiers($appliquer);

        $this->newLine();
        if ($total === 0) {
            $this->warn('Aucune occurrence modifiable trouvée dans la base de données ni dans les fichiers texte.');
        } elseif ($appliquer) {
            $this->info("{$total} occurrence(s) remplacée(s). Lancez ensuite : php artisan view:clear");
        } else {
            $this->info("{$total} occurrence(s) trouvée(s). Relancez avec --appliquer pour les remplacer.");
        }

        return self::SUCCESS;
    }

    private function remplacer(string $texte, int &$nb = 0): string
    {
        $resultat = preg_replace_callback(self::MOTIF, function (array $m) use (&$nb) {
            $nb++;

            return mb_strtoupper($m[0]) === $m[0]
                ? 'MINISTÈRE DU PLAN ET DU DÉVELOPPEMENT'
                : 'Ministère du Plan et du Développement';
        }, $texte);

        return $resultat ?? $texte;
    }

    /** Parcourt toutes les colonnes texte de la base. */
    private function baseDeDonnees(bool $appliquer): int
    {
        $ignorees = ['migrations', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs', 'password_reset_tokens'];
        $total = 0;

        foreach (Schema::getTables() as $table) {
            $nomTable = $table['name'];
            if (in_array($nomTable, $ignorees, true)) {
                continue;
            }

            foreach (Schema::getColumns($nomTable) as $colonne) {
                $type = strtolower((string) ($colonne['type_name'] ?? $colonne['type'] ?? ''));
                if (! preg_match('/char|text|json/', $type)) {
                    continue;
                }
                $nomColonne = $colonne['name'];

                $valeurs = DB::table($nomTable)->where($nomColonne, 'like', '%conomie%')->pluck($nomColonne);

                foreach ($valeurs->unique() as $ancien) {
                    $nb = 0;
                    $nouveau = $this->remplacer((string) $ancien, $nb);
                    if ($nb === 0) {
                        continue;
                    }

                    $total += $nb;
                    $this->line("  BASE     {$nomTable}.{$nomColonne} : {$nb} occurrence(s)");

                    if ($appliquer) {
                        DB::table($nomTable)->where($nomColonne, $ancien)->update([$nomColonne => $nouveau]);
                    }
                }
            }
        }

        return $total;
    }

    /** Parcourt les fichiers texte générés (documents de démonstration, SVG, HTML...). */
    private function fichiers(bool $appliquer): int
    {
        $extensions = ['html', 'htm', 'txt', 'md', 'svg', 'xml', 'css', 'js', 'json', 'csv', 'rtf'];
        $racines = [storage_path('app'), public_path()];
        $total = 0;
        $binaires = [];

        foreach ($racines as $racine) {
            if (! is_dir($racine)) {
                continue;
            }

            $iterateur = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($racine, \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterateur as $fichier) {
                if (! $fichier->isFile()) {
                    continue;
                }

                $chemin = $fichier->getPathname();
                if (preg_match('#[\\\\/](vendor|node_modules|build)[\\\\/]#', $chemin)) {
                    continue;
                }

                $extension = strtolower($fichier->getExtension());

                if (in_array($extension, ['pdf', 'docx', 'doc', 'odt'], true)) {
                    $binaires[] = $chemin;
                    continue;
                }

                if (! in_array($extension, $extensions, true) || $fichier->getSize() > 5 * 1024 * 1024) {
                    continue;
                }

                $contenu = file_get_contents($chemin);
                if ($contenu === false) {
                    continue;
                }

                $nb = 0;
                $nouveau = $this->remplacer($contenu, $nb);
                if ($nb === 0) {
                    continue;
                }

                $total += $nb;
                $this->line("  FICHIER  {$chemin} : {$nb} occurrence(s)");

                if ($appliquer) {
                    file_put_contents($chemin, $nouveau);
                }
            }
        }

        if ($binaires !== []) {
            $this->newLine();
            $this->warn('Fichiers PDF / Word : leur texte ne peut pas être remplacé automatiquement.');
            $this->line('S\'ils affichent encore l\'ancien nom, il faut les régénérer :');
            foreach (array_slice($binaires, 0, 30) as $chemin) {
                $this->line("  - {$chemin}");
            }
        }

        return $total;
    }
}
