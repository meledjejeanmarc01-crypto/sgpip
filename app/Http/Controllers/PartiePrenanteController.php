<?php

namespace App\Http\Controllers;

use App\Models\PartiePrenante;
use App\Models\Projet;
use Illuminate\Http\Request;

// PARTIE_PRENANTE — cahier : "id, libéllé, sig, projet_id, Type partie prenante_id" (RG51).
class PartiePrenanteController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'sig' => 'nullable|string|max:50',
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
            'libelle' => 'required|string|max:255',
            'sig' => 'nullable|string|max:50',
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
