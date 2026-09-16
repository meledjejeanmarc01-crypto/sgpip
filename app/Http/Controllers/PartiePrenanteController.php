<?php

namespace App\Http\Controllers;

use App\Models\PartiePrenante;
use App\Models\Projet;
use Illuminate\Http\Request;

class PartiePrenanteController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'groupe_acteurs' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'type_partie_prenante_id' => 'nullable|exists:types_partie_prenante,id',
        ]);
        $data['projet_id'] = $projet->id;
        PartiePrenante::create($data);
        return back()->with('success', 'Partie prenante ajoutée avec succès.');
    }

    public function update(Request $request, PartiePrenante $partiePrenante)
    {
        $data = $request->validate([
            'groupe_acteurs' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'type_partie_prenante_id' => 'nullable|exists:types_partie_prenante,id',
        ]);
        $partiePrenante->update($data);
        return back()->with('success', 'Partie prenante mise à jour.');
    }

    public function destroy(PartiePrenante $partiePrenante)
    {
        $projet = $partiePrenante->projet;
        $partiePrenante->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Partie prenante supprimée.');
    }
}
