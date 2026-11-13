<?php

namespace App\Http\Controllers;

use App\Models\Bailleur;
use App\Models\Financement;
use App\Models\Projet;
use App\Support\CoherenceFinanciere;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

// FINANCEMENT — cahier : rattaché à un seul bailleur et à un seul projet.
class FinancementController extends Controller
{
    public function index(Request $request)
    {
        $financements = Financement::with(['projet', 'bailleur', 'conventionFinancement'])
            ->when($request->q, fn ($q) => $q->where('reference', 'like', "%{$request->q}%"))
            ->orderByDesc('date')
            ->paginate(15)
            ->withQueryString();
        return view('financements.index', compact('financements'));
    }

    public function create()
    {
        [$projets, $bailleurs] = $this->referenceData();
        return view('financements.create', compact('projets', 'bailleurs'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // RG17 : on ne crée un financement que pour un projet que l'on gère.
        $this->autoriserProjet((int) $data['projet_id']);

        // Règle : financé > décaissé > dépensé (le financé augmente : rien à vérifier en pratique).
        $variations = [];
        CoherenceFinanciere::ajuster($variations, $data['projet_id'], 'F', (float) $data['montant_engage']);
        CoherenceFinanciere::verifier($variations, 'montant_engage');

        Financement::create($data);
        return redirect()->route('financements.index')->with('success', 'Financement enregistré avec succès.');
    }

    public function edit(Financement $financement)
    {
        // Le middleware projet.acces ne contrôle pas les requêtes GET : on vérifie ici.
        $this->autoriserProjet((int) $financement->projet_id);

        [$projets, $bailleurs] = $this->referenceData();
        return view('financements.edit', compact('financement', 'projets', 'bailleurs'));
    }

    public function update(Request $request, Financement $financement)
    {
        $data = $this->validateData($request, $financement->id);

        // RG17 : le projet actuel ET le projet visé par le formulaire doivent être gérés par l'utilisateur.
        $this->autoriserProjet((int) $financement->projet_id);
        $this->autoriserProjet((int) $data['projet_id']);

        if ((int) $data['projet_id'] !== (int) $financement->projet_id && $financement->decaissements()->exists()) {
            throw ValidationException::withMessages([
                'projet_id' => 'Impossible de changer le projet : des décaissements sont rattachés à ce financement.',
            ]);
        }

        // Règle : financé > décaissé > dépensé (retrait de l'ancien montant, ajout du nouveau).
        $variations = [];
        CoherenceFinanciere::ajuster($variations, $financement->projet_id, 'F', -(float) $financement->montant_engage);
        CoherenceFinanciere::ajuster($variations, $data['projet_id'], 'F', (float) $data['montant_engage']);
        CoherenceFinanciere::verifier($variations, 'montant_engage');

        $financement->update($data);
        return redirect()->route('financements.index')->with('success', 'Financement mis à jour.');
    }

    public function destroy(Financement $financement)
    {
        $this->autoriserProjet((int) $financement->projet_id);

        if ($financement->decaissements()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des décaissements sont rattachés à ce financement.');
        }

        $variations = [];
        CoherenceFinanciere::ajuster($variations, $financement->projet_id, 'F', -(float) $financement->montant_engage);
        if ($erreur = CoherenceFinanciere::erreur($variations)) {
            return back()->with('error', 'Impossible de supprimer : '.$erreur);
        }

        $financement->delete();
        return back()->with('success', 'Financement supprimé.');
    }

    private function referenceData(): array
    {
        $user = auth()->user();

        // Un gestionnaire ne peut choisir que parmi les projets qu'il gère ; l'administrateur voit tout.
        $projets = Projet::orderBy('intitule')
            ->when(! $user->isAdministrateur(), fn ($q) => $q->whereIn('id', $user->projetsGeres()->pluck('projets.id')))
            ->get();

        return [
            $projets,
            Bailleur::orderBy('nom')->get(),
        ];
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $donnees = $request->validate([
            'montant_engage' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reference' => 'required|string|max:50|unique:financements,reference,'.$ignoreId,
            'type_source' => 'nullable|in:tresor,emprunt,don,participation_collectivites,participation_populations,participation_secteur_prive,ppp,fonds_propres_parapublics',
            'numero_convention' => 'nullable|string|max:100',
            'date_convention' => 'nullable|date',
            'projet_id' => 'required|exists:projets,id',
            'bailleur_id' => 'required|exists:bailleurs,id',
            // Feuille PLANIFICATION, section 1 : détail de la tranche de financement
            'code_guichet' => 'nullable|string|max:50',
            'devise' => 'nullable|string|max:50',
            'taux_change' => 'nullable|numeric|min:0',
            'montant_devise' => 'nullable|numeric|min:0',
            'ressources_internes' => 'nullable|numeric|min:0',
            'ressources_externes' => 'nullable|numeric|min:0',
            'statut' => 'nullable|string|max:100',
            'beneficiaire' => 'nullable|string|max:255',
            'montant_don' => 'nullable|numeric|min:0',
            'montant_emprunt' => 'nullable|numeric|min:0',
            'observation' => 'nullable|string',
        ], [
            'montant_engage.required' => 'Le montant financé est obligatoire.',
            'montant_engage.numeric' => 'Le montant financé doit être un nombre.',
            'montant_engage.min' => 'Le montant financé ne peut pas être négatif.',
        ], [
            // Nom affiché dans les autres messages de validation (le champ garde son nom technique).
            'montant_engage' => 'montant financé',
        ]);

        // Total de la tranche = ressources internes + ressources externes (quand les deux sont renseignées).
        if (isset($donnees['ressources_internes'], $donnees['ressources_externes'])
            && abs(($donnees['ressources_internes'] + $donnees['ressources_externes']) - $donnees['montant_engage']) > 1) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'ressources_internes' => 'La somme des ressources internes et externes doit être égale au montant financé.',
            ]);
        }

        return $donnees;
    }
}
