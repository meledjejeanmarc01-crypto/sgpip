<?php

namespace App\Http\Controllers;

use App\Models\Acteur;
use App\Models\GroupeActeur;
use App\Models\Projet;
use Illuminate\Http\Request;

class ActeurController extends Controller
{
    public function index()
    {
        $acteurs = Acteur::with('groupeActeur')->orderBy('libelle')->paginate(15);
        return view('acteurs.index', compact('acteurs'));
    }

    public function create()
    {
        $groupes = GroupeActeur::orderBy('libelle')->get();
        return view('acteurs.create', compact('groupes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'groupe_acteur_id' => 'nullable|exists:groupes_acteur,id',
        ]);
        Acteur::create($data);
        return redirect()->route('acteurs.index')->with('success', 'Acteur créé avec succès.');
    }

    public function edit(Acteur $acteur)
    {
        $groupes = GroupeActeur::orderBy('libelle')->get();
        return view('acteurs.edit', compact('acteur', 'groupes'));
    }

    public function update(Request $request, Acteur $acteur)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'groupe_acteur_id' => 'nullable|exists:groupes_acteur,id',
        ]);
        $acteur->update($data);
        return redirect()->route('acteurs.index')->with('success', 'Acteur mis à jour.');
    }

    public function destroy(Acteur $acteur)
    {
        $acteur->delete();
        return back()->with('success', 'Acteur supprimé.');
    }

    public function attacher(Request $request, Projet $projet)
    {
        $data = $request->validate(['acteur_id' => 'required|exists:acteurs,id']);
        $projet->acteurs()->syncWithoutDetaching([$data['acteur_id']]);
        return back()->with('success', 'Acteur associé au projet.');
    }

    public function detacher(Projet $projet, Acteur $acteur)
    {
        $projet->acteurs()->detach($acteur->id);
        return back()->with('success', 'Acteur retiré du projet.');
    }
}
