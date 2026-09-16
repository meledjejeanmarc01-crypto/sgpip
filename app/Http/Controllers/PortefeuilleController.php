<?php

namespace App\Http\Controllers;

use App\Models\Portefeuille;
use App\Models\Projet;
use Illuminate\Http\Request;

class PortefeuilleController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'appartenance_pnd' => 'required|boolean',
            'libelle_associe' => 'nullable|string|max:255',
        ]);
        $data['projet_id'] = $projet->id;
        Portefeuille::create($data);
        return back()->with('success', 'Portefeuille ajouté avec succès.');
    }

    public function update(Request $request, Portefeuille $portefeuille)
    {
        $data = $request->validate([
            'appartenance_pnd' => 'required|boolean',
            'libelle_associe' => 'nullable|string|max:255',
        ]);
        $portefeuille->update($data);
        return back()->with('success', 'Portefeuille mis à jour.');
    }

    public function destroy(Portefeuille $portefeuille)
    {
        $projet = $portefeuille->projet;
        $portefeuille->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Portefeuille supprimé.');
    }
}
