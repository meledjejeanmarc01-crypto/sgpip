<?php

namespace App\Http\Controllers;

use App\Models\GroupeActeur;
use Illuminate\Http\Request;

class GroupeActeurController extends Controller
{
    public function index()
    {
        $groupes = GroupeActeur::withCount('acteurs')->orderBy('libelle')->paginate(15);
        return view('groupes_acteur.index', compact('groupes'));
    }

    public function create()
    {
        return view('groupes_acteur.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:groupes_acteur,libelle']);
        GroupeActeur::create($data);
        return redirect()->route('groupes-acteur.index')->with('success', 'Groupe d\'acteur créé avec succès.');
    }

    public function edit(GroupeActeur $groupe_acteur)
    {
        return view('groupes_acteur.edit', ['groupe' => $groupe_acteur]);
    }

    public function update(Request $request, GroupeActeur $groupe_acteur)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:groupes_acteur,libelle,'.$groupe_acteur->id]);
        $groupe_acteur->update($data);
        return redirect()->route('groupes-acteur.index')->with('success', 'Groupe d\'acteur mis à jour.');
    }

    public function destroy(GroupeActeur $groupe_acteur)
    {
        if ($groupe_acteur->acteurs()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des acteurs sont rattachés à ce groupe.');
        }
        $groupe_acteur->delete();
        return back()->with('success', 'Groupe d\'acteur supprimé.');
    }
}
