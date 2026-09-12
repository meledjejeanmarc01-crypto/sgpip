<?php

namespace App\Http\Controllers;

use App\Models\Risque;
use App\Models\Projet;
use Illuminate\Http\Request;

class RisqueController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'consequence' => 'nullable|string',
            'probabilite' => 'required|in:faible,moyenne,forte',
            'criticite' => 'required|in:faible,moyenne,elevee',
            'mesure_mitigation' => 'nullable|string',
            'type_strategie' => 'nullable|string|max:255',
        ]);
        $data['projet_id'] = $projet->id;
        Risque::create($data);
        return back()->with('success', 'Risque ajouté avec succès.');
    }

    public function update(Request $request, Risque $risque)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'consequence' => 'nullable|string',
            'probabilite' => 'required|in:faible,moyenne,forte',
            'criticite' => 'required|in:faible,moyenne,elevee',
            'mesure_mitigation' => 'nullable|string',
            'type_strategie' => 'nullable|string|max:255',
        ]);
        $risque->update($data);
        return back()->with('success', 'Risque mis à jour.');
    }

    public function destroy(Risque $risque)
    {
        $projet = $risque->projet;
        $risque->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Risque supprimé.');
    }
}
