<?php

namespace App\Http\Controllers;

use App\Models\Axe;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AxeController extends Controller
{
    public function store(Request $request, Programme $programme)
    {
        $data = $request->validate([
            // Un même libellé d'axe ne peut exister qu'une fois dans un programme.
            'libelle' => ['required', 'string', 'max:255', Rule::unique('axes', 'libelle')->where('programme_id', $programme->id)],
        ], [
            'libelle.unique' => 'Cet axe existe déjà dans ce programme.',
        ]);
        $data['programme_id'] = $programme->id;
        $axe = Axe::create($data);

        // Création rapide depuis le formulaire de projet (réponse JSON, sans quitter la page).
        if ($request->wantsJson()) {
            return response()->json(['id' => $axe->id, 'libelle' => $axe->libelle, 'sigle' => $programme->nom], 201);
        }

        return back()->with('success', 'Axe ajouté avec succès.');
    }

    public function update(Request $request, Axe $axe)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);
        $axe->update($data);
        return back()->with('success', 'Axe mis à jour.');
    }

    public function destroy(Axe $axe)
    {
        $programme = $axe->programme;
        $axe->delete();
        return redirect()->route('programmes.show', $programme)->with('success', 'Axe supprimé.');
    }
}
