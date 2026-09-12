<?php

namespace App\Http\Controllers;

use App\Models\Cible;
use App\Models\Projet;
use Illuminate\Http\Request;

class CibleController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'type_beneficiaire' => 'nullable|string|max:255',
            'acteur' => 'nullable|string|max:255',
            'probleme_specifique' => 'nullable|string',
            'attentes' => 'nullable|string',
            'craintes' => 'nullable|string',
        ]);
        $data['projet_id'] = $projet->id;
        Cible::create($data);
        return back()->with('success', 'Cible ajoutée avec succès.');
    }

    public function update(Request $request, Cible $cible)
    {
        $data = $request->validate([
            'type_beneficiaire' => 'nullable|string|max:255',
            'acteur' => 'nullable|string|max:255',
            'probleme_specifique' => 'nullable|string',
            'attentes' => 'nullable|string',
            'craintes' => 'nullable|string',
        ]);
        $cible->update($data);
        return back()->with('success', 'Cible mise à jour.');
    }

    public function destroy(Cible $cible)
    {
        $projet = $cible->projet;
        $cible->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Cible supprimée.');
    }
}
