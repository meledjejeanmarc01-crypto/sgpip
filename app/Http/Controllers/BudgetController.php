<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Projet;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $budgets = Budget::with('projet')
            ->when($request->filled('projet_id'), fn ($q) => $q->where('projet_id', $request->projet_id))
            ->when($request->filled('exercice'), fn ($q) => $q->where('exercice', $request->exercice))
            ->latest('date')
            ->paginate(15)
            ->withQueryString();

        $totalPrevu = Budget::when($request->filled('projet_id'), fn ($q) => $q->where('projet_id', $request->projet_id))
            ->when($request->filled('exercice'), fn ($q) => $q->where('exercice', $request->exercice))
            ->sum('montant_prevu');

        $projets = Projet::orderBy('intitule')->get(['id', 'intitule', 'reference']);
        $exercices = Budget::select('exercice')->distinct()->orderByDesc('exercice')->pluck('exercice');

        return view('budgets.index', compact('budgets', 'totalPrevu', 'projets', 'exercices'));
    }

    public function store(Request $request, Projet $projet)
    {
        $validated = $request->validate([
            'montant_prevu' => ['required', 'numeric', 'min:0'],
            'exercice' => ['required', 'integer', 'digits:4'],
            'source_financement' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'observation' => ['nullable', 'string'],
        ]);

        $projet->budgets()->create($validated);

        return back()->with('success', 'Budget ajouté avec succès.');
    }

    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'montant_prevu' => ['required', 'numeric', 'min:0'],
            'exercice' => ['required', 'integer', 'digits:4'],
            'source_financement' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'observation' => ['nullable', 'string'],
        ]);

        $budget->update($validated);

        return back()->with('success', 'Budget modifié avec succès.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();

        return back()->with('success', 'Budget supprimé avec succès.');
    }
}
