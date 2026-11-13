<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Projet;
use App\Support\CoherenceFinanciere;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        $projets = $this->projetsAccessibles();
        return view('depenses.create', compact('projets'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // RG17 : on ne crée une dépense que pour un projet que l'on gère.
        $this->autoriserProjetDuFormulaire($data['projet_id'] ?? null);

        // Règle : financé > décaissé > dépensé.
        $variations = [];
        CoherenceFinanciere::ajuster($variations, $data['projet_id'] ?? null, 'E', (float) $data['montant']);
        CoherenceFinanciere::verifier($variations, 'montant');

        Depense::create($data);
        return redirect()->route('depenses.index')->with('success', 'Dépense enregistrée avec succès.');
    }

    public function edit(Depense $depense)
    {
        // Le middleware projet.acces ne contrôle pas les requêtes GET : on vérifie ici.
        $this->autoriserDepense($depense);

        $projets = $this->projetsAccessibles();
        return view('depenses.edit', compact('depense', 'projets'));
    }

    public function update(Request $request, Depense $depense)
    {
        $data = $this->validateData($request, $depense->id);

        // RG17 : la dépense actuelle ET le projet visé par le formulaire doivent relever d'un projet géré.
        $this->autoriserDepense($depense);
        $this->autoriserProjetDuFormulaire($data['projet_id'] ?? null);

        // Règle : financé > décaissé > dépensé (retrait de l'ancien montant, ajout du nouveau).
        $variations = [];
        CoherenceFinanciere::ajuster($variations, $depense->projet_id, 'E', -(float) $depense->montant);
        CoherenceFinanciere::ajuster($variations, $data['projet_id'] ?? null, 'E', (float) $data['montant']);
        CoherenceFinanciere::verifier($variations, 'montant');

        $depense->update($data);
        return redirect()->route('depenses.index')->with('success', 'Dépense mise à jour.');
    }

    public function destroy(Depense $depense)
    {
        $this->autoriserDepense($depense);

        if ($depense->taches()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des tâches sont rattachées à cette dépense.');
        }
        $depense->delete();
        return back()->with('success', 'Dépense supprimée.');
    }

    /**
     * Contrôle d'une dépense existante : son projet doit être géré par l'utilisateur.
     * Une dépense sans projet ne peut être modifiée que par l'administrateur.
     */
    private function autoriserDepense(Depense $depense): void
    {
        if ($depense->projet_id) {
            $this->autoriserProjet((int) $depense->projet_id);
        } elseif (! auth()->user()->isAdministrateur()) {
            abort(403, "Cette dépense n'est rattachée à aucun projet : seul l'administrateur peut la modifier.");
        }
    }

    /**
     * Contrôle du projet choisi dans le formulaire.
     * Pour un gestionnaire, le projet est obligatoire (sans lui, la dépense échapperait au contrôle).
     */
    private function autoriserProjetDuFormulaire($projetId): void
    {
        if (! $projetId) {
            if (! auth()->user()->isAdministrateur()) {
                throw ValidationException::withMessages([
                    'projet_id' => 'Le projet est obligatoire.',
                ]);
            }
            return;
        }

        $this->autoriserProjet((int) $projetId);
    }

    // Un gestionnaire ne peut choisir que parmi les projets qu'il gère ; l'administrateur voit tout.
    private function projetsAccessibles()
    {
        $user = auth()->user();

        return Projet::orderBy('intitule')
            ->when(! $user->isAdministrateur(), fn ($q) => $q->whereIn('id', $user->projetsGeres()->pluck('projets.id')))
            ->get();
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
