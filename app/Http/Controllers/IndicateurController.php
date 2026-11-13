<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Indicateur;
use Illuminate\Http\Request;

class IndicateurController extends Controller
{
    public function store(Request $request, Activite $activite)
    {
        $data = $this->validateData($request);
        $data['activite_id'] = $activite->id;
        $cibles = $this->extraireCibles($data);
        $indicateur = Indicateur::create($data);
        $this->syncCibles($indicateur, $cibles);
        return back()->with('success', 'Indicateur ajouté avec succès.');
    }

    public function update(Request $request, Indicateur $indicateur)
    {
        $data = $this->validateData($request);
        $cibles = $this->extraireCibles($data);
        $indicateur->update($data);
        $this->syncCibles($indicateur, $cibles);
        return back()->with('success', 'Indicateur mis à jour.');
    }

    public function destroy(Indicateur $indicateur)
    {
        $projet = $indicateur->activite->projet;
        $indicateur->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Indicateur supprimé.');
    }

    // RG12 : quatre cibles trimestrielles ; la valeur cible globale en est la somme si elle n'est pas saisie.
    private function extraireCibles(array &$data): array
    {
        $cibles = $data['cibles_trimestrielles'] ?? [];
        unset($data['cibles_trimestrielles']);

        $renseignees = array_filter($cibles, fn ($v) => $v !== null && $v !== '');
        if (($data['valeur_cible'] ?? null) === null && !empty($renseignees)) {
            $data['valeur_cible'] = array_sum($renseignees);
        }

        return $cibles;
    }

    private function syncCibles(Indicateur $indicateur, array $cibles): void
    {
        foreach ([1, 2, 3, 4] as $trimestre) {
            $valeur = $cibles[$trimestre] ?? null;
            if ($valeur === null || $valeur === '') {
                $indicateur->ciblesTrimestrielles()->where('trimestre', $trimestre)->delete();
                continue;
            }
            $indicateur->ciblesTrimestrielles()->updateOrCreate(['trimestre' => $trimestre], ['valeur_cible' => $valeur]);
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:255',
            'unite' => 'nullable|string|max:50',
            'situation_reference' => 'nullable|string|max:255',
            'valeur_cible' => 'nullable|numeric',
            'valeur_realisee' => 'nullable|numeric',
            'cibles_trimestrielles' => 'nullable|array',
            'cibles_trimestrielles.*' => 'nullable|numeric|min:0',
            'date_mesure' => 'nullable|date',
            'sources_verification' => 'nullable|string|max:255',
            'hypothese' => 'nullable|string|max:255',
            'resultat_attendu_id' => 'nullable|exists:resultats_attendus,id',
        ]);
    }
}
