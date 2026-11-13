<?php

namespace App\Http\Controllers;

use App\Models\ActionPnd;
use App\Models\Axe;
use App\Models\FichePip;
use App\Models\Projet;
use App\Models\Secteur;
use App\Models\Structure;
use App\Models\User;
use App\Notifications\DecisionProjetNotification;
use App\Models\ZoneLocalisation;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function index(Request $request)
    {
        $projets = Projet::with(['structure', 'secteur', 'zonesExecution'])
            ->when($request->q, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('reference', 'like', "%{$request->q}%")
                      ->orWhere('intitule', 'like', "%{$request->q}%");
                });
            })
            ->when($request->secteur_id, fn ($q) => $q->where('secteur_id', $request->secteur_id))
            ->when($request->structure_id, fn ($q) => $q->where('structure_id', $request->structure_id))
            ->when($request->zone_execution_id, fn ($q) => $q->whereHas('zonesExecution', fn ($zq) => $zq->where('zones_localisation.id', $request->zone_execution_id)))
            ->when($request->statut, fn ($q) => $q->where('statut', $request->statut))
            ->when($request->date_debut, fn ($q) => $q->whereDate('date_debut', '>=', $request->date_debut))
            ->when($request->date_fin, fn ($q) => $q->whereDate('date_fin', '<=', $request->date_fin))
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $secteurs = Secteur::orderBy('libelle')->get();
        $structures = Structure::orderBy('libelle')->get();
        $zones = ZoneLocalisation::orderBy('libelle')->get();

        return view('projets.index', compact('projets', 'secteurs', 'structures', 'zones'));
    }

    public function create()
    {
        $this->authorize('create', Projet::class);

        [$structures, $secteurs, $zones, $fichesPip, $axes, $actionsPnd] = $this->referenceData();
        return view('projets.create', compact('structures', 'secteurs', 'zones', 'fichesPip', 'axes', 'actionsPnd'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Projet::class);

        $data = $this->validateData($request);
        [$fichesPip, $zonesExecution, $milieuxExecution] = $this->extractRelations($data);

        $projet = Projet::create($data);
        $this->syncGestionnaires($projet, $request, true);
        if (!empty($fichesPip)) {
            $projet->fichesPip()->sync($fichesPip);
        }
        $projet->zonesExecution()->sync($zonesExecution);
        $this->syncMilieuxExecution($projet, $milieuxExecution);

        return redirect()->route('projets.show', $projet)->with('success', 'Projet créé avec succès.');
    }

    public function show(Projet $projet)
    {
        $projet->load([
            'structure', 'secteur', 'zonesExecution', 'axe.programme', 'actionPnd', 'fichesPip.programme',
            'activites.taches', 'activites.indicateurs', 'activites.composante',
            'financements.bailleur', 'financements.decaissements', 'financements.conventionFinancement',
            'depenses', 'rapports.utilisateur',
            'composantes', 'risques', 'partiesPrenantes.typePartiePrenante', 'etudes',
            'objectifsSpecifiques.resultatsAttendus', 'milieuxExecution',
            'activites.indicateurs.ciblesTrimestrielles', 'gestionnaires', 'decideur',
        ]);
        return view('projets.show', compact('projet'));
    }

    public function edit(Projet $projet)
    {
        // Le middleware projet.acces ne contrôle pas les requêtes GET : on vérifie ici.
        $this->authorize('update', $projet);

        [$structures, $secteurs, $zones, $fichesPip, $axes, $actionsPnd] = $this->referenceData();
        $projet->load('fichesPip', 'zonesExecution', 'milieuxExecution', 'gestionnaires');
        return view('projets.edit', compact('projet', 'structures', 'secteurs', 'zones', 'fichesPip', 'axes', 'actionsPnd'));
    }

    public function update(Request $request, Projet $projet)
    {
        $data = $this->validateData($request, $projet->id);
        [$fichesPip, $zonesExecution, $milieuxExecution] = $this->extractRelations($data);

        $projet->update($data);
        $this->syncGestionnaires($projet, $request, false);
        $projet->fichesPip()->sync($fichesPip);
        $projet->zonesExecution()->sync($zonesExecution);
        $this->syncMilieuxExecution($projet, $milieuxExecution);

        return redirect()->route('projets.show', $projet)->with('success', 'Projet mis à jour avec succès.');
    }

    public function destroy(Projet $projet)
    {
        // Contrôle des suppressions (§18) : un projet porteur de données financières ne se supprime pas.
        if ($projet->financements()->exists() || $projet->depenses()->exists()) {
            return back()->with('error', "Ce projet ne peut pas être supprimé : des financements ou des dépenses y sont rattachés.");
        }

        $projet->fichesPip()->detach();
        $projet->zonesExecution()->detach();
        $projet->delete();
        return redirect()->route('projets.index')->with('success', 'Projet supprimé.');
    }

    // §9.4 : le projet saisi est soumis pour validation.
    public function soumettre(Projet $projet)
    {
        if (!in_array($projet->statut_validation, ['brouillon', 'rejete'], true)) {
            return back()->with('error', 'Ce projet a déjà été soumis.');
        }

        $projet->update([
            'statut_validation' => 'soumis',
            'date_soumission' => now(),
            'motif_decision' => null,
        ]);

        return back()->with('success', 'Projet soumis pour validation.');
    }

    // §9.4 : validation du projet, avec notification de la décision.
    public function valider(Projet $projet)
    {
        if ($projet->statut_validation !== 'soumis') {
            return back()->with('error', "Seul un projet soumis peut être validé.");
        }

        $projet->update([
            'statut_validation' => 'valide',
            'date_decision' => now(),
            'decide_par' => auth()->id(),
            'motif_decision' => null,
        ]);
        $this->notifierDecision($projet, 'valide', null);

        return back()->with('success', 'Projet validé. Les gestionnaires et la structure porteuse ont été notifiés.');
    }

    public function rejeter(Request $request, Projet $projet)
    {
        $data = $request->validate(['motif_decision' => 'required|string|max:1000'], [], ['motif_decision' => 'motif du rejet']);

        if ($projet->statut_validation !== 'soumis') {
            return back()->with('error', "Seul un projet soumis peut être rejeté.");
        }

        $projet->update([
            'statut_validation' => 'rejete',
            'date_decision' => now(),
            'decide_par' => auth()->id(),
            'motif_decision' => $data['motif_decision'],
        ]);
        $this->notifierDecision($projet, 'rejete', $data['motif_decision']);

        return back()->with('success', 'Projet rejeté. Les gestionnaires et la structure porteuse ont été notifiés.');
    }

    private function notifierDecision(Projet $projet, string $decision, ?string $motif): void
    {
        $notification = new DecisionProjetNotification($projet, $decision, $motif);

        foreach ($projet->gestionnaires as $gestionnaire) {
            $gestionnaire->notify($notification);
        }

        // §9.4 : la structure porteuse est notifiée de la décision (si une adresse e-mail est renseignée).
        $email = $projet->structure?->email;
        if ($email) {
            try {
                \Illuminate\Support\Facades\Notification::route('mail', $email)->notify($notification);
            } catch (\Throwable $e) {
                report($e); // un échec d'envoi ne doit pas bloquer la décision
            }
        }
    }

    // RG17 : gestionnaires du projet.
    // Après la création, seul l'administrateur modifie la liste des gestionnaires.
    // À la création, un gestionnaire reste toujours gestionnaire de son projet,
    // et si personne n'est choisi, le créateur l'est.
    private function syncGestionnaires(Projet $projet, Request $request, bool $creation): void
    {
        $user = $request->user();

        if (! $creation && ! $user->isAdministrateur()) {
            return;
        }

        $ids = array_filter((array) $request->input('gestionnaires', []));
        $ids = User::whereIn('id', $ids)
            ->whereIn('role', ['administrateur', 'gestionnaire_projet'])
            ->pluck('id')->all();

        if ($creation && ($user->role === 'gestionnaire_projet' || empty($ids))) {
            $ids[] = $user->id;
        }

        $projet->gestionnaires()->sync(array_unique($ids));
    }

    public function carte()
    {
        // Un rond par zone d'exécution ayant au moins un projet (coordonnées de la zone,
        // ou à défaut celles de sa localisation) : nombre de projets, montant, avancement moyen.
        $zonesCarte = ZoneLocalisation::whereHas('projets')
            ->with('localisation.niveau', 'projets:id,cout_estimatif,avancement_physique')
            ->withCount('projets')
            ->get();

        $zonesCarteData = $zonesCarte
            ->map(function ($z) {
                $coordonnees = $z->coordonnees;

                return [
                    'id' => $z->id,
                    'libelle' => $z->libelle,
                    'type' => $z->localisation?->niveau?->libelle ?? "Hors Côte d'Ivoire",
                    'lat' => $coordonnees[0] ?? null,
                    'lng' => $coordonnees[1] ?? null,
                    'nb' => $z->projets_count,
                    'montant' => (float) $z->projets->sum('cout_estimatif'),
                    'avancement' => round((float) $z->projets->avg('avancement_physique'), 1),
                ];
            })
            ->filter(fn ($z) => $z['lat'] !== null && $z['lng'] !== null)
            ->values();

        // Liste affichée à côté de la carte : les projets ne sont pas dessinés sur la carte.
        $projetsIndex = Projet::with('secteur:id,libelle', 'zonesExecution:id,libelle')
            ->latest()
            ->get(['id', 'intitule', 'reference', 'statut', 'secteur_id', 'cout_estimatif', 'avancement_physique'])
            ->map(fn ($p) => [
                'id' => $p->id,
                'intitule' => $p->intitule,
                'reference' => $p->reference,
                'statut' => $p->statut,
                'secteur' => $p->secteur?->libelle,
                'cout' => (float) $p->cout_estimatif,
                'avancement' => (float) $p->avancement_physique,
                'zone_ids' => $p->zonesExecution->pluck('id')->map(fn ($id) => (string) $id)->values(),
                'zones' => $p->zonesExecution->pluck('libelle')->implode(', '),
                'url' => route('projets.show', $p),
            ])
            ->values();

        return view('projets.carte', compact('zonesCarteData', 'projetsIndex'));
    }

    private function referenceData(): array
    {
        return [
            Structure::orderBy('libelle')->get(),
            Secteur::orderBy('libelle')->get(),
            ZoneLocalisation::orderBy('libelle')->get(),
            FichePip::orderBy('nom')->get(),
            Axe::with('programme')->orderBy('libelle')->get(),
            ActionPnd::orderBy('libelle')->get(),
        ];
    }

    /**
     * Sépare du tableau validé les relations qui ne sont pas des colonnes directes de 'projets'
     * (fiches PIP, zones d'exécution RG41, milieux d'exécution RG37).
     */
    private function extractRelations(array &$data): array
    {
        $fichesPip = $data['fiches_pip'] ?? [];
        unset($data['fiches_pip']);

        $zonesExecution = $data['zones_execution'] ?? [];
        unset($data['zones_execution']);

        $milieuxExecution = $data['milieux_execution'] ?? [];
        unset($data['milieux_execution']);

        unset($data['gestionnaires']);

        return [$fichesPip, $zonesExecution, $milieuxExecution];
    }

    private function syncMilieuxExecution(Projet $projet, array $categories): void
    {
        $projet->milieuxExecution()->delete();
        foreach (array_unique($categories) as $categorie) {
            $projet->milieuxExecution()->create(['categorie' => $categorie]);
        }
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'reference' => 'required|string|max:50|unique:projets,reference,'.$ignoreId,
            'code_pip' => 'nullable|string|max:100',
            'intitule' => 'required|string|max:255',
            'contexte' => 'nullable|string',
            'objectif' => 'nullable|string',
            'cout_estimatif' => 'required|numeric|min:0',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'avancement_physique' => 'required|integer|min:0|max:100',
            'statut' => 'required|in:planifie,en_cours,termine,suspendu,retarde',
            'maitre_ouvrage' => 'nullable|string|max:255',
            'maitre_ouvrage_delegue' => 'nullable|string|max:255',
            'maitre_oeuvre' => 'nullable|string|max:255',
            // Fiche de maturation, étape 1
            'date_identification' => 'nullable|date',
            'maitre_ouvrage_associe' => 'nullable|string|max:255',
            'maitre_oeuvre_delegue' => 'nullable|string|max:255',
            'maitre_oeuvre_associe' => 'nullable|string|max:255',
            'section_budgetaire' => 'nullable|string|max:255',
            'responsable_nom' => 'nullable|string|max:255',
            'responsable_fonction' => 'nullable|string|max:255',
            'responsable_telephone' => 'nullable|string|max:50',
            'responsable_cellulaire' => 'nullable|string|max:50',
            'responsable_email' => 'nullable|email|max:255',
            'responsable_adresse' => 'nullable|string|max:255',
            'redacteur_nom' => 'nullable|string|max:255',
            'redacteur_fonction' => 'nullable|string|max:255',
            'redacteur_telephone' => 'nullable|string|max:50',
            'redacteur_cellulaire' => 'nullable|string|max:50',
            'redacteur_email' => 'nullable|email|max:255',
            'redacteur_adresse' => 'nullable|string|max:255',
            'perimetre_sections' => 'nullable|array|max:5',
            'perimetre_sections.*' => 'nullable|string|max:255',
            'attributions_ministere' => 'nullable|string',
            // Cadre de gestion et charges récurrentes
            'partenaires_projet' => 'nullable|string',
            'plan_implementation' => 'nullable|string',
            'charges_recurrentes_date_debut' => 'nullable|date',
            'charges_recurrentes_duree' => 'nullable|string|max:255',
            // Fiche de maturation, étape 2
            'appartient_portefeuille_pnd' => 'nullable|boolean',
            'portefeuille_pnd_projets' => 'nullable|string',
            'ancrage_document_source' => 'nullable|string|max:255',
            'ancrage_objectifs_strategies' => 'nullable|string',
            'duree_prevue' => 'nullable|string|max:100',
            'action_pnd_id' => 'required|exists:actions_pnd,id', // Un projet est rattaché à une seule Action PND
            'programme_budgetaire' => 'nullable|string',
            'odd_concerne' => 'nullable|string',
            'domaine_impact_socio_eco' => 'nullable|string|max:255',
            'milieux_execution' => 'nullable|array',
            'milieux_execution.*' => 'in:rural,urbain,inter_urbain,peri_urbain',
            'type_projet' => 'required|in:investissement,routine',
            'cible_trimestre_1' => 'nullable|string|max:255',
            'cible_trimestre_2' => 'nullable|string|max:255',
            'cible_trimestre_3' => 'nullable|string|max:255',
            'cible_trimestre_4' => 'nullable|string|max:255',
            'code_pjgouv' => 'nullable|string|max:100',
            'code_psgouv' => 'nullable|string|max:100',
            'appartenance' => 'nullable|string|max:255',
            'probleme' => 'nullable|string',
            'attentes_projet' => 'nullable|string',
            'craintes_projet' => 'nullable|string',
            'taille' => 'nullable|string|max:100',
            'observations' => 'nullable|string',
            'structure_id' => 'required|exists:structures,id',
            'secteur_id' => 'required|exists:secteurs,id',
            'zones_execution' => 'required|array|min:1',
            'zones_execution.*' => 'exists:zones_localisation,id',
            'axe_id' => 'nullable|exists:axes,id',
            'fiches_pip' => 'nullable|array',
            'fiches_pip.*' => 'exists:fiches_pip,id',
            'gestionnaires' => 'nullable|array',
            'gestionnaires.*' => 'exists:users,id',
        ]);

        // Périmètre multi-sectoriel : on ne garde que les sections renseignées.
        $data['perimetre_sections'] = array_values(array_filter($data['perimetre_sections'] ?? [], fn ($v) => filled($v)));

        return $data;
    }
}
