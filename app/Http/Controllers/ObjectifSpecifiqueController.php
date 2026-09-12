<?php

namespace App\Http\Controllers;

use App\Models\ObjectifSpecifique;
use App\Models\Projet;
use Illuminate\Http\Request;

class ObjectifSpecifiqueController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);
        $data['projet_id'] = $projet->id;
        ObjectifSpecifique::create($data);
        return back()->with('success', 'Objectif spécifique ajouté avec succès.');
    }

    public function update(Request $request, ObjectifSpecifique $objectifSpecifique)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);
        $objectifSpecifique->update($data);
        return back()->with('success', 'Objectif spécifique mis à jour.');
    }

    public function destroy(ObjectifSpecifique $objectifSpecifique)
    {
        $projet = $objectifSpecifique->projet;
        $objectifSpecifique->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Objectif spécifique supprimé.');
    }
}
