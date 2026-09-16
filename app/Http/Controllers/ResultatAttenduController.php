<?php

namespace App\Http\Controllers;

use App\Models\Objectif;
use App\Models\ResultatAttendu;
use Illuminate\Http\Request;

class ResultatAttenduController extends Controller
{
    public function store(Request $request, Objectif $objectif)
    {
        $data = $request->validate([
            'niveau' => 'required|in:impact,effet,extrant',
            'libelle' => 'required|string|max:255',
            'situation_reference' => 'nullable|string|max:255',
            'cible' => 'nullable|string|max:255',
            'valeur_realisee' => 'nullable|string|max:255',
            'reste_a_atteindre' => 'nullable|string|max:255',
            'commentaire' => 'nullable|string',
        ]);
        $data['objectif_id'] = $objectif->id;
        ResultatAttendu::create($data);
        return back()->with('success', 'Résultat attendu ajouté avec succès.');
    }

    public function update(Request $request, ResultatAttendu $resultat_attendu)
    {
        $data = $request->validate([
            'niveau' => 'required|in:impact,effet,extrant',
            'libelle' => 'required|string|max:255',
            'situation_reference' => 'nullable|string|max:255',
            'cible' => 'nullable|string|max:255',
            'valeur_realisee' => 'nullable|string|max:255',
            'reste_a_atteindre' => 'nullable|string|max:255',
            'commentaire' => 'nullable|string',
        ]);
        $resultat_attendu->update($data);
        return back()->with('success', 'Résultat attendu mis à jour.');
    }

    public function destroy(ResultatAttendu $resultat_attendu)
    {
        $projet = $resultat_attendu->objectif->projet;
        $resultat_attendu->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Résultat attendu supprimé.');
    }
}
