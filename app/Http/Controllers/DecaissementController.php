<?php

namespace App\Http\Controllers;

use App\Models\Bailleur;
use App\Models\Decaissement;
use App\Models\Financement;
use App\Support\CoherenceFinanciere;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DecaissementController extends Controller
{
    public function index(Request $request)
    {
        $decaissements = Decaissement::with(['bailleur', 'financement.projet'])
            ->when($request->q, fn ($q) => $q->where('reference', 'like', "%{$request->q}%"))
            ->orderByDesc('date')
            ->paginate(15)
            ->withQueryString();
        return view('decaissements.index', compact('decaissements'));
    }

    public function create()
    {
        [$bailleurs, $financements] = $this->referenceData();
        return view('decaissements.create', compact('bailleurs', 'financements'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // RG17 : on ne crée un décaissement que sur un financement d'un projet que l'on gère.
        $this->autoriserFinancementDuFormulaire($data['financement_id'] ?? null);

        // Règle : financé > décaissé > dépensé.
        $variations = [];
        CoherenceFinanciere::ajuster($variations, CoherenceFinanciere::projetDuFinancement($data['financement_id'] ?? null), 'D', (float) $data['montant']);
        CoherenceFinanciere::verifier($variations, 'montant');

        Decaissement::create($data);
        return redirect()->route('decaissements.index')->with('success', 'Décaissement enregistré avec succès.');
    }

    public function edit(Decaissement $decaissement)
    {
        // Le middleware projet.acces ne contrôle pas les requêtes GET : on vérifie ici.
        $this->autoriserDecaissement($decaissement);

        [$bailleurs, $financements] = $this->referenceData();
        return view('decaissements.edit', compact('decaissement', 'bailleurs', 'financements'));
    }

    public function update(Request $request, Decaissement $decaissement)
    {
        $data = $this->validateData($request, $decaissement->id);

        // RG17 : le décaissement actuel ET le financement visé par le formulaire doivent relever d'un projet géré.
        $this->autoriserDecaissement($decaissement);
        $this->autoriserFinancementDuFormulaire($data['financement_id'] ?? null);

        // Règle : financé > décaissé > dépensé (retrait de l'ancien montant, ajout du nouveau).
        $variations = [];
        CoherenceFinanciere::ajuster($variations, CoherenceFinanciere::projetDuFinancement($decaissement->financement_id), 'D', -(float) $decaissement->montant);
        CoherenceFinanciere::ajuster($variations, CoherenceFinanciere::projetDuFinancement($data['financement_id'] ?? null), 'D', (float) $data['montant']);
        CoherenceFinanciere::verifier($variations, 'montant');

        $decaissement->update($data);
        return redirect()->route('decaissements.index')->with('success', 'Décaissement mis à jour.');
    }

    public function destroy(Decaissement $decaissement)
    {
        $this->autoriserDecaissement($decaissement);

        $variations = [];
        CoherenceFinanciere::ajuster($variations, CoherenceFinanciere::projetDuFinancement($decaissement->financement_id), 'D', -(float) $decaissement->montant);
        if ($erreur = CoherenceFinanciere::erreur($variations)) {
            return back()->with('error', 'Impossible de supprimer : '.$erreur);
        }

        $decaissement->delete();
        return back()->with('success', 'Décaissement supprimé.');
    }

    /**
     * Contrôle d'un décaissement existant : son financement doit relever d'un projet géré par l'utilisateur.
     * Un décaissement sans financement n'a pas de projet : seul l'administrateur peut le modifier.
     */
    private function autoriserDecaissement(Decaissement $decaissement): void
    {
        if ($decaissement->financement_id) {
            $this->autoriserProjet((int) $decaissement->financement?->projet_id);
        } elseif (! auth()->user()->isAdministrateur()) {
            abort(403, "Ce décaissement n'est rattaché à aucun financement : seul l'administrateur peut le modifier.");
        }
    }

    /**
     * Contrôle du financement choisi dans le formulaire.
     * Pour un gestionnaire, le financement est obligatoire (c'est lui qui relie le décaissement à un projet).
     */
    private function autoriserFinancementDuFormulaire($financementId): void
    {
        $financement = $financementId ? Financement::find($financementId) : null;

        if (! $financement) {
            if (! auth()->user()->isAdministrateur()) {
                throw ValidationException::withMessages([
                    'financement_id' => 'Le financement est obligatoire.',
                ]);
            }
            return;
        }

        $this->autoriserProjet((int) $financement->projet_id);
    }

    private function referenceData(): array
    {
        $user = auth()->user();

        // Un gestionnaire ne voit que les financements de ses projets ; l'administrateur voit tout.
        $financements = Financement::with('projet')
            ->when(! $user->isAdministrateur(), fn ($q) => $q->whereIn('projet_id', $user->projetsGeres()->pluck('projets.id')))
            ->orderByDesc('date')
            ->get();

        return [
            Bailleur::orderBy('nom')->get(),
            $financements,
        ];
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reference' => 'required|string|max:50|unique:decaissements,reference,'.$ignoreId,
            'bailleur_id' => 'required|exists:bailleurs,id',
            'financement_id' => 'nullable|exists:financements,id',
        ]);
    }
}
