<?php

namespace App\Http\Controllers;

use App\Models\Composante;
use App\Models\Projet;
use Illuminate\Http\Request;

class ComposanteController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'budget_previsionnel' => 'nullable|numeric|min:0',
        ]);
        $data['projet_id'] = $projet->id;
        Composante::create($data);
        return back()->with('success', 'Composante ajoutée avec succès.');
    }

    public function update(Request $request, Composante $composante)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'budget_previsionnel' => 'nullable|numeric|min:0',
        ]);
        $composante->update($data);
        return back()->with('success', 'Composante mise à jour.');
    }

    public function destroy(Composante $composante)
    {
        $projet = $composante->projet;
        $composante->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Composante supprimée.');
    }
}
