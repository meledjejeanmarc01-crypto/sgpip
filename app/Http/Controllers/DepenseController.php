<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Projet;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function index(Request $request)
    {
        $depenses = Depense::with('projet')
            ->when($request->q, fn ($q) => $q->where('libelle', 'like', "%{$request->q}%")->orWhere('reference', 'like', "%{$request->q}%"))
            ->orderByDesc('date')
            ->paginate(15)
            ->withQueryString();
        return view('depenses.index', compact('depenses'));
    }

    public function create()
    {
        $projets = Projet::orderBy('intitule')->get();
        return view('depenses.create', compact('projets'));
    }

    public function store(Request $request)
    {
        Depense::create($this->validateData($request));
        return redirect()->route('depenses.index')->with('success', 'Dépense enregistrée avec succès.');
    }

    public function edit(Depense $depense)
    {
        $projets = Projet::orderBy('intitule')->get();
        return view('depenses.edit', compact('depense', 'projets'));
    }

    public function update(Request $request, Depense $depense)
    {
        $depense->update($this->validateData($request, $depense->id));
        return redirect()->route('depenses.index')->with('success', 'Dépense mise à jour.');
    }

    public function destroy(Depense $depense)
    {
        if ($depense->taches()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des tâches sont rattachées à cette dépense.');
        }
        $depense->delete();
        return back()->with('success', 'Dépense supprimée.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reference' => 'required|string|max:50|unique:depenses,reference,'.$ignoreId,
            'projet_id' => 'nullable|exists:projets,id',
        ]);
    }
}
