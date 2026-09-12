<?php

namespace App\Http\Controllers;

use App\Models\FichePip;
use App\Models\Programme;
use App\Models\Projet;
use Illuminate\Http\Request;

class FichePipController extends Controller
{
    public function index(Request $request)
    {
        $fiches = FichePip::with('programme')
            ->when($request->q, fn ($q) => $q->where('numero', 'like', "%{$request->q}%")->orWhere('nom', 'like', "%{$request->q}%"))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();
        return view('fiches_pip.index', compact('fiches'));
    }

    public function create()
    {
        $programmes = Programme::orderBy('nom')->get();
        return view('fiches_pip.create', compact('programmes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numero' => 'required|string|max:50|unique:fiches_pip,numero',
            'nom' => 'required|string|max:255',
            'programme_id' => 'required|exists:programmes,id',
        ]);
        FichePip::create($data);
        return redirect()->route('fiches-pip.index')->with('success', 'Fiche PIP créée avec succès.');
    }

    public function show(FichePip $fiche_pip)
    {
        $fiche_pip->load('programme', 'projets');
        return view('fiches_pip.show', ['fiche' => $fiche_pip]);
    }

    public function edit(FichePip $fiche_pip)
    {
        $programmes = Programme::orderBy('nom')->get();
        return view('fiches_pip.edit', ['fiche' => $fiche_pip, 'programmes' => $programmes]);
    }

    public function update(Request $request, FichePip $fiche_pip)
    {
        $data = $request->validate([
            'numero' => 'required|string|max:50|unique:fiches_pip,numero,'.$fiche_pip->id,
            'nom' => 'required|string|max:255',
            'programme_id' => 'required|exists:programmes,id',
        ]);
        $fiche_pip->update($data);
        return redirect()->route('fiches-pip.index')->with('success', 'Fiche PIP mise à jour.');
    }

    public function destroy(FichePip $fiche_pip)
    {
        $fiche_pip->projets()->detach();
        $fiche_pip->delete();
        return back()->with('success', 'Fiche PIP supprimée.');
    }

    public function associerProjets(Request $request, FichePip $fiche_pip)
    {
        $request->validate(['projets' => 'array', 'projets.*' => 'exists:projets,id']);
        $fiche_pip->projets()->sync($request->input('projets', []));
        return back()->with('success', 'Association des projets mise à jour.');
    }
}
