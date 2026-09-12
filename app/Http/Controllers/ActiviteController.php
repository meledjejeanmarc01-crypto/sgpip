<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Projet;
use Illuminate\Http\Request;

class ActiviteController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'intitule' => 'required|string|max:255',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'taux_avancement' => 'required|integer|min:0|max:100',
        ]);
        $data['projet_id'] = $projet->id;
        Activite::create($data);
        return back()->with('success', 'Activité ajoutée avec succès.');
    }

    public function update(Request $request, Activite $activite)
    {
        $data = $request->validate([
            'intitule' => 'required|string|max:255',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'taux_avancement' => 'required|integer|min:0|max:100',
        ]);
        $activite->update($data);
        return back()->with('success', 'Activité mise à jour.');
    }

    public function destroy(Activite $activite)
    {
        $projet = $activite->projet;
        $activite->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Activité supprimée.');
    }
}
