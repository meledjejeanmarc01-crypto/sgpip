<?php

namespace App\Http\Controllers;

use App\Models\Etat;
use Illuminate\Http\Request;

class EtatController extends Controller
{
    public function index()
    {
        $etats = Etat::withCount('financements')->orderBy('libelle')->paginate(15);
        return view('etats.index', compact('etats'));
    }

    public function create()
    {
        return view('etats.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Etat::create($data);
        return redirect()->route('etats.index')->with('success', "Acteur institutionnel « État » créé avec succès.");
    }

    public function edit(Etat $etat)
    {
        return view('etats.edit', compact('etat'));
    }

    public function update(Request $request, Etat $etat)
    {
        $data = $this->validateData($request);
        $etat->update($data);
        return redirect()->route('etats.index')->with('success', 'Fiche « État » mise à jour.');
    }

    public function destroy(Etat $etat)
    {
        if ($etat->financements()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des financements sont rattachés.');
        }
        $etat->delete();
        return back()->with('success', 'Fiche supprimée.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'sigle' => 'required|string|max:50',
            'libelle' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
        ]);
    }
}
