<?php

namespace App\Support;

use App\Models\Decaissement;
use App\Models\Depense;
use App\Models\Financement;
use Illuminate\Validation\ValidationException;

/**
 * Règle de cohérence, projet par projet :
 *     montant financé > montant décaissé > montant dépensé
 *
 * Les contrôleurs décrivent la variation que provoque la saisie (ajout, modification,
 * suppression) sous la forme  [projet_id => ['F' => ±x, 'D' => ±y, 'E' => ±z]]
 * (F = financé, D = décaissé, E = dépensé) ; la saisie est refusée si le résultat
 * viole la règle.
 */
class CoherenceFinanciere
{
    /** Cumule une variation pour un projet. */
    public static function ajuster(array &$variations, $projetId, string $cle, float $valeur): void
    {
        if (! $projetId) {
            return;
        }
        $variations[$projetId][$cle] = ($variations[$projetId][$cle] ?? 0) + $valeur;
    }

    /** Projet auquel appartient un financement (null si aucun). */
    public static function projetDuFinancement($financementId): ?int
    {
        if (! $financementId) {
            return null;
        }
        $projetId = Financement::whereKey($financementId)->value('projet_id');

        return $projetId ? (int) $projetId : null;
    }

    /** Totaux actuels d'un projet : financé (F), décaissé (D), dépensé (E). */
    public static function totaux(int $projetId): array
    {
        $financementIds = Financement::where('projet_id', $projetId)->pluck('id');

        return [
            'F' => (float) Financement::where('projet_id', $projetId)->sum('montant_engage'),
            'D' => (float) Decaissement::whereIn('financement_id', $financementIds)->sum('montant'),
            'E' => (float) Depense::where('projet_id', $projetId)->sum('montant'),
        ];
    }

    /** Message d'erreur si les variations violent la règle, sinon null. */
    public static function erreur(array $variations): ?string
    {
        foreach ($variations as $projetId => $v) {
            $total = self::totaux((int) $projetId);
            $F = round($total['F'] + ($v['F'] ?? 0), 2);
            $D = round($total['D'] + ($v['D'] ?? 0), 2);
            $E = round($total['E'] + ($v['E'] ?? 0), 2);

            // Financé > décaissé : contrôlé seulement si le financé baisse ou le décaissé augmente.
            if ((($v['F'] ?? 0) < 0 || ($v['D'] ?? 0) > 0) && $D > 0 && $F <= $D) {
                return 'Le montant financé du projet ('.self::fcfa($F).') doit rester supérieur '
                    .'à son montant décaissé ('.self::fcfa($D).').';
            }

            // Décaissé > dépensé : contrôlé seulement si le décaissé baisse ou le dépensé augmente.
            if ((($v['D'] ?? 0) < 0 || ($v['E'] ?? 0) > 0) && $E > 0 && $D <= $E) {
                return 'Le montant décaissé du projet ('.self::fcfa($D).') doit rester supérieur '
                    .'à son montant dépensé ('.self::fcfa($E).'). Enregistrez d\'abord les décaissements correspondants.';
            }
        }

        return null;
    }

    /** Comme erreur(), mais lève une erreur de validation rattachée au champ $champ. */
    public static function verifier(array $variations, string $champ): void
    {
        if ($message = self::erreur($variations)) {
            throw ValidationException::withMessages([$champ => $message]);
        }
    }

    private static function fcfa(float $montant): string
    {
        return number_format($montant, 0, ',', ' ').' FCFA';
    }
}
