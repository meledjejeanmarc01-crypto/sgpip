<?php

namespace App\Http\Controllers;

use App\Models\OpportuniteEmploi;
use App\Models\Projet;
use Illuminate\Http\Request;

class OpportuniteEmploiController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'type_emploi' => 'required|in:direct,indirect',
            'phase' => 'required|in:realisation,exploitation',
            'nombre_emplois_prevus' => 'nullable|integer|min:0',
            'duree_activite_previsionnelle' => 'nullable|integer|min:0',
        ]);
        $data['projet_id'] = $projet->id;
        OpportuniteEmploi::create($data);
        return back()->with('success', 'Opportunité d\'emploi ajoutée avec succès.');
    }

    public function update(Request $request, OpportuniteEmploi $opportunites_emploi)
    {
        $data = $request->validate([
            'type_emploi' => 'required|in:direct,indirect',
            'phase' => 'required|in:realisation,exploitation',
            'nombre_emplois_prevus' => 'nullable|integer|min:0',
            'duree_activite_previsionnelle' => 'nullable|integer|min:0',
        ]);
        $opportunites_emploi->update($data);
        return back()->with('success', 'Opportunité d\'emploi mise à jour.');
    }

    public function destroy(OpportuniteEmploi $opportunites_emploi)
    {
        $projet = $opportunites_emploi->projet;
        $opportunites_emploi->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Opportunité d\'emploi supprimée.');
    }
}
