<?php

namespace App\Http\Controllers;

use App\Models\AnalyseCausale;
use App\Models\Projet;
use Illuminate\Http\Request;

class AnalyseCausaleController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'probleme_identifie' => 'required|string',
            'cause' => 'required|string',
            'effet' => 'required|string',
            'type_analyse_causale_id' => 'nullable|exists:types_analyse_causale,id',
        ]);
        $data['libelle'] = \Illuminate\Support\Str::limit($data['probleme_identifie'], 250, '');
        $data['projet_id'] = $projet->id;
        AnalyseCausale::create($data);
        return back()->with('success', 'Analyse causale ajoutée avec succès.');
    }

    public function update(Request $request, AnalyseCausale $analyses_causale)
    {
        $data = $request->validate([
            'probleme_identifie' => 'required|string',
            'cause' => 'required|string',
            'effet' => 'required|string',
            'type_analyse_causale_id' => 'nullable|exists:types_analyse_causale,id',
        ]);
        $data['libelle'] = \Illuminate\Support\Str::limit($data['probleme_identifie'], 250, '');
        $analyses_causale->update($data);
        return back()->with('success', 'Analyse causale mise à jour.');
    }

    public function destroy(AnalyseCausale $analyses_causale)
    {
        $projet = $analyses_causale->projet;
        $analyses_causale->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Analyse causale supprimée.');
    }
}
