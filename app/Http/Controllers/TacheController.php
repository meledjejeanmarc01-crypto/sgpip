<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Depense;
use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function store(Request $request, Activite $activite)
    {
        $data = $this->validateData($request);
        $data['activite_id'] = $activite->id;
        Tache::create($data);
        return back()->with('success', 'Tâche ajoutée avec succès.');
    }

    public function update(Request $request, Tache $tache)
    {
        $tache->update($this->validateData($request));
        return back()->with('success', 'Tâche mise à jour.');
    }

    public function destroy(Tache $tache)
    {
        $projet = $tache->activite->projet;
        $tache->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Tâche supprimée.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'intitule' => 'required|string|max:255',
            'description' => 'nullable|string',
            'statut' => 'nullable|in:a_faire,en_cours,termine',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'depense_id' => 'nullable|exists:depenses,id',
        ]);
    }
}
