<?php

namespace App\Http\Controllers;

use App\Models\PaysEtranger;
use Illuminate\Http\Request;

// PAYS_ETRANGER — cahier : "id, libellé" (RG48).
class PaysEtrangerController extends Controller
{
    public function index()
    {
        $paysEtrangers = PaysEtranger::withCount('zonesExecution')->orderBy('libelle')->paginate(15);
        return view('pays_etrangers.index', compact('paysEtrangers'));
    }

    public function create()
    {
        return view('pays_etrangers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:pays_etrangers,libelle', 'code_iso' => 'nullable|alpha|min:2|max:3']);
        PaysEtranger::create($data);
        return redirect()->route('pays-etrangers.index')->with('success', 'Pays étranger ajouté avec succès.');
    }

    public function edit(PaysEtranger $pays_etranger)
    {
        return view('pays_etrangers.edit', ['pays' => $pays_etranger]);
    }

    public function update(Request $request, PaysEtranger $pays_etranger)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:pays_etrangers,libelle,'.$pays_etranger->id, 'code_iso' => 'nullable|alpha|min:2|max:3']);
        $pays_etranger->update($data);
        return redirect()->route('pays-etrangers.index')->with('success', 'Pays étranger mis à jour.');
    }

    public function destroy(PaysEtranger $pays_etranger)
    {
        if ($pays_etranger->zonesExecution()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des zones d\'exécution sont rattachées à ce pays.');
        }
        $pays_etranger->delete();
        return back()->with('success', 'Pays étranger supprimé.');
    }
}
