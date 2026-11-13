<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Models\Rapport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Les données de démonstration créent des fiches « document » et « rapport » en base,
 * mais pas les fichiers qu'elles désignent : « Ouvrir » et « Télécharger » répondent alors
 * « Le fichier demandé est introuvable ». Cette commande crée ces fichiers à partir
 * du modèle database/demo/document-demo.pdf.
 *
 * Elle ne touche JAMAIS aux fichiers réellement envoyés par les utilisateurs : seuls les
 * chemins générés par les seeders (documents/projet-N-presentation.pdf et
 * rapports/rapport-demo.pdf) sont concernés.
 */
class CreerFichiersDemo extends Command
{
    protected $signature = 'demo:creer-fichiers
                            {--remplacer : Remplace aussi les anciens fichiers de démonstration déjà présents}';

    protected $description = 'Crée les fichiers PDF de démonstration manquants (documents et rapports)';

    private const MOTIF_DOCUMENT_DEMO = '#^documents/projet-\d+-presentation\.pdf$#';
    private const FICHIER_RAPPORT_DEMO = 'rapports/rapport-demo.pdf';

    public function handle(): int
    {
        $modele = database_path('demo/document-demo.pdf');
        if (! is_file($modele)) {
            $this->error("Modèle introuvable : {$modele}");

            return self::FAILURE;
        }

        $contenu = file_get_contents($modele);
        $remplacer = (bool) $this->option('remplacer');

        // --- Documents (disque « local », comme DocumentController) ---
        $disqueDocuments = Storage::disk('local');
        $crees = 0;
        $introuvablesReels = [];

        foreach (Document::query()->whereNotNull('fichier')->cursor() as $document) {
            $estDemo = (bool) preg_match(self::MOTIF_DOCUMENT_DEMO, $document->fichier);
            $existe = $disqueDocuments->exists($document->fichier);

            if (! $estDemo) {
                if (! $existe) {
                    $introuvablesReels[] = [$document->id, $document->titre, $document->fichier];
                }
                continue;
            }

            if ($existe && ! $remplacer) {
                continue;
            }

            $disqueDocuments->put($document->fichier, $contenu);
            Document::whereKey($document->getKey())->update([
                'taille' => strlen($contenu),
                'extension' => 'pdf',
            ]);
            $crees++;
        }

        // --- Rapports (disque « public », comme RapportController) ---
        $disqueRapports = Storage::disk('public');
        $rapportsMisAJour = 0;

        if (Rapport::where('fichier', self::FICHIER_RAPPORT_DEMO)->exists()
            && ($remplacer || ! $disqueRapports->exists(self::FICHIER_RAPPORT_DEMO))) {
            $disqueRapports->put(self::FICHIER_RAPPORT_DEMO, $contenu);
            $rapportsMisAJour = 1;
        }

        $this->info("Documents de démonstration créés ou remplacés : {$crees}");
        $this->info('Fichier de démonstration des rapports : '.($rapportsMisAJour ? 'créé ou remplacé' : 'déjà présent (utilisez --remplacer pour le refaire)'));

        if ($introuvablesReels !== []) {
            $this->newLine();
            $this->warn('Documents saisis par des utilisateurs dont le fichier est introuvable (non modifiés) :');
            $this->table(['ID', 'Titre', 'Chemin attendu'], $introuvablesReels);
        }

        return self::SUCCESS;
    }
}
