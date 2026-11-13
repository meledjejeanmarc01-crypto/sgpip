<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use Illuminate\Http\Request;

class SecteurController extends Controller
{
    public function index()
    {
        $secteurs = Secteur::withCount('projets')->orderBy('libelle')->paginate(15);
        return view('secteurs.index', compact('secteurs'));
    }

    public function create()
    {
        return view('secteurs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:secteurs,libelle']);
        $secteur = Secteur::create($data);

        // Création rapide depuis le formulaire de projet (réponse JSON, sans quitter la page).
        if ($request->wantsJson()) {
            return response()->json(['id' => $secteur->id, 'libelle' => $secteur->libelle, 'sigle' => null], 201);
        }

        return redirect()->route('secteurs.index')->with('success', 'Secteur créé avec succès.');
    }

    public function edit(Secteur $secteur)
    {
        return view('secteurs.edit', compact('secteur'));
    }

    public function update(Request $request, Secteur $secteur)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:secteurs,libelle,'.$secteur->id]);
        $secteur->update($data);
        return redirect()->route('secteurs.index')->with('success', 'Secteur mis à jour.');
    }

    public function destroy(Secteur $secteur)
    {
        if ($secteur->projets()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des projets sont rattachés à ce secteur.');
        }
        $secteur->delete();
        return back()->with('success', 'Secteur supprimé.');
    }
}
