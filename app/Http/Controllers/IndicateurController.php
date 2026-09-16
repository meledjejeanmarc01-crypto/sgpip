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
        Indicateur::create($data);
        return back()->with('success', 'Indicateur ajouté avec succès.');
    }

    public function update(Request $request, Indicateur $indicateur)
    {
        $indicateur->update($this->validateData($request));
        return back()->with('success', 'Indicateur mis à jour.');
    }

    public function destroy(Indicateur $indicateur)
    {
        $projet = $indicateur->activite->projet;
        $indicateur->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Indicateur supprimé.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:255',
            'unite' => 'nullable|string|max:50',
            'situation_reference' => 'nullable|string|max:255',
            'valeur_cible' => 'nullable|numeric',
            'valeur_realisee' => 'nullable|numeric',
            'date_mesure' => 'nullable|date',
            'sources_verification' => 'nullable|string|max:255',
            'hypothese' => 'nullable|string|max:255',
            'resultat_attendu_id' => 'nullable|exists:resultats_attendus,id',
        ]);
    }
}
