<?php

namespace App\Http\Controllers;

use App\Models\Marche;
use App\Models\Projet;
use Illuminate\Http\Request;

class MarcheController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'objet' => 'required|string|max:255',
            'etat' => 'nullable|string|max:255',
            'duree' => 'nullable|string|max:100',
            'cout' => 'nullable|numeric|min:0',
            'montant_engage' => 'nullable|numeric|min:0',
            'montant_liquide' => 'nullable|numeric|min:0',
            'montant_paye' => 'nullable|numeric|min:0',
        ]);
        $data['projet_id'] = $projet->id;
        Marche::create($data);
        return back()->with('success', 'Marché ajouté avec succès.');
    }

    public function update(Request $request, Marche $marche)
    {
        $data = $request->validate([
            'objet' => 'required|string|max:255',
            'etat' => 'nullable|string|max:255',
            'duree' => 'nullable|string|max:100',
            'cout' => 'nullable|numeric|min:0',
            'montant_engage' => 'nullable|numeric|min:0',
            'montant_liquide' => 'nullable|numeric|min:0',
            'montant_paye' => 'nullable|numeric|min:0',
        ]);
        $marche->update($data);
        return back()->with('success', 'Marché mis à jour.');
    }

    public function destroy(Marche $marche)
    {
        $projet = $marche->projet;
        $marche->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Marché supprimé.');
    }
}
