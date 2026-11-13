<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Support\FicheVolets;
use Illuminate\Http\Request;

// Saisie des volets de la fiche projet (voir App\Support\FicheVolets) depuis la fiche d'un projet.
class FicheVoletController extends Controller
{
    /** Types de champs qui désignent un élément du projet, et la relation correspondante du projet. */
    private const LISTES_DU_PROJET = [
        'marche' => 'marches',
        'financement' => 'financements',
        'activite' => 'activites',
        'composante' => 'composantes',
    ];

    public function store(Request $request, Projet $projet, string $volet)
    {
        // RG17 : on ne saisit un volet que pour un projet que l'on gère.
        $this->authorize('update', $projet);

        $def = FicheVolets::get($volet);
        $data = $request->validate(FicheVolets::regles($def), [], FicheVolets::attributs($def));

        $this->verifierRattachement($def, $data, $projet);

        if ($def['scope'] === 'projet') {
            $data['projet_id'] = $projet->id;
        }

        $def['model']::create($data);

        return back()->with('success', $def['singulier'].' ajouté.');
    }

    public function update(Request $request, string $volet, int $id)
    {
        $def = FicheVolets::get($volet);
        $ligne = $def['model']::findOrFail($id);

        // RG17 : la ligne modifiée doit appartenir à un projet que l'on gère
        // (la route n'a pas de projet dans l'URL : il se déduit de la ligne).
        $projet = Projet::findOrFail($this->projetDeLaLigne($def, $ligne));
        $this->authorize('update', $projet);

        $data = $request->validate(FicheVolets::regles($def), [], FicheVolets::attributs($def));

        // L'élément choisi doit appartenir au même projet que la ligne modifiée.
        $this->verifierRattachement($def, $data, $projet);

        $ligne->update($data);

        return back()->with('success', $def['singulier'].' mis à jour.');
    }

    public function destroy(string $volet, int $id)
    {
        $def = FicheVolets::get($volet);
        $ligne = $def['model']::findOrFail($id);

        // RG17 : même contrôle que pour la modification.
        $projet = Projet::findOrFail($this->projetDeLaLigne($def, $ligne));
        $this->authorize('update', $projet);

        $ligne->delete();

        return back()->with('success', $def['singulier'].' supprimé.');
    }

    /** Un marché, financement, activité ou composante choisi doit appartenir au projet concerné. */
    private function verifierRattachement(array $def, array $data, Projet $projet): void
    {
        foreach ($def['champs'] as $c) {
            if (! isset(self::LISTES_DU_PROJET[$c['type']]) || empty($data[$c['name']])) {
                continue;
            }
            $relation = self::LISTES_DU_PROJET[$c['type']];
            abort_unless($projet->{$relation}()->whereKey($data[$c['name']])->exists(), 403);
        }
    }

    private function projetDeLaLigne(array $def, $ligne): int
    {
        if ($def['scope'] === 'projet') {
            return (int) $ligne->projet_id;
        }
        // scope : marche | financement | activite | composante (relation du même nom sur la ligne)
        return (int) $ligne->{$def['scope']}->projet_id;
    }
}
