<?php

namespace App\Http\Controllers;

use App\Models\Etude;
use App\Models\Projet;
use Illuminate\Http\Request;

class EtudeController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'mode_execution' => 'nullable|string|max:255',
            'structure_realisation' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'date_demarrage' => 'nullable|date',
            'duree' => 'nullable|string|max:100',
            'etat_execution' => 'nullable|string|max:255',
            'type_etude' => 'nullable|string|max:255',
            'date_realisation' => 'nullable|date',
        ]);
        $data['projet_id'] = $projet->id;
        Etude::create($data);
        return back()->with('success', 'Étude ajoutée avec succès.');
    }

    public function update(Request $request, Etude $etude)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'mode_execution' => 'nullable|string|max:255',
            'structure_realisation' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'date_demarrage' => 'nullable|date',
            'duree' => 'nullable|string|max:100',
            'etat_execution' => 'nullable|string|max:255',
            'type_etude' => 'nullable|string|max:255',
            'date_realisation' => 'nullable|date',
        ]);
        $etude->update($data);
        return back()->with('success', 'Étude mise à jour.');
    }

    public function destroy(Etude $etude)
    {
        $projet = $etude->projet;
        $etude->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Étude supprimée.');
    }
}
