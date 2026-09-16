<?php

namespace App\Http\Controllers;

use App\Models\CritereEvaluation;
use App\Models\Projet;
use Illuminate\Http\Request;

class CritereEvaluationController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'critere' => 'required|string|max:255',
            'sous_critere' => 'nullable|string|max:255',
            'appreciation' => 'nullable|in:total,partiel,faible,oui,non',
            'justification' => 'nullable|string',
        ]);
        $data['projet_id'] = $projet->id;
        CritereEvaluation::create($data);
        return back()->with('success', 'Critère d\'évaluation ajouté avec succès.');
    }

    public function update(Request $request, CritereEvaluation $criteres_evaluation)
    {
        $data = $request->validate([
            'critere' => 'required|string|max:255',
            'sous_critere' => 'nullable|string|max:255',
            'appreciation' => 'nullable|in:total,partiel,faible,oui,non',
            'justification' => 'nullable|string',
        ]);
        $criteres_evaluation->update($data);
        return back()->with('success', 'Critère d\'évaluation mis à jour.');
    }

    public function destroy(CritereEvaluation $criteres_evaluation)
    {
        $projet = $criteres_evaluation->projet;
        $criteres_evaluation->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Critère d\'évaluation supprimé.');
    }
}
