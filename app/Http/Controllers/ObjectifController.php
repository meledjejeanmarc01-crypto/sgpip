<?php

namespace App\Http\Controllers;

use App\Models\Objectif;
use App\Models\Projet;
use Illuminate\Http\Request;

class ObjectifController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_objectif_id' => 'nullable|exists:types_objectif,id',
        ]);
        $data['projet_id'] = $projet->id;
        Objectif::create($data);
        return back()->with('success', 'Objectif ajouté avec succès.');
    }

    public function update(Request $request, Objectif $objectif)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_objectif_id' => 'nullable|exists:types_objectif,id',
        ]);
        $objectif->update($data);
        return back()->with('success', 'Objectif mis à jour.');
    }

    public function destroy(Objectif $objectif)
    {
        $projet = $objectif->projet;
        $objectif->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Objectif supprimé.');
    }
}
