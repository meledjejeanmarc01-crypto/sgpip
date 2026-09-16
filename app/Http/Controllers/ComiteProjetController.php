<?php

namespace App\Http\Controllers;

use App\Models\ComiteProjet;
use App\Models\Projet;
use Illuminate\Http\Request;

class ComiteProjetController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'type' => 'required|in:supervision,pilotage,technique,suivi_evaluation,audit_controle',
            'role' => 'nullable|string|max:255',
            'composition' => 'nullable|string',
            'observation' => 'nullable|string',
        ]);
        $data['projet_id'] = $projet->id;
        ComiteProjet::create($data);
        return back()->with('success', 'Comité de projet ajouté avec succès.');
    }

    public function update(Request $request, ComiteProjet $comites_projet)
    {
        $data = $request->validate([
            'type' => 'required|in:supervision,pilotage,technique,suivi_evaluation,audit_controle',
            'role' => 'nullable|string|max:255',
            'composition' => 'nullable|string',
            'observation' => 'nullable|string',
        ]);
        $comites_projet->update($data);
        return back()->with('success', 'Comité de projet mis à jour.');
    }

    public function destroy(ComiteProjet $comites_projet)
    {
        $projet = $comites_projet->projet;
        $comites_projet->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Comité de projet supprimé.');
    }
}
