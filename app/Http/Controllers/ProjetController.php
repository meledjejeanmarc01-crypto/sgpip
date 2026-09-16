<?php

namespace App\Http\Controllers;

use App\Models\Axe;
use App\Models\FichePip;
use App\Models\Projet;
use App\Models\Secteur;
use App\Models\Structure;
use App\Models\ZoneLocalisation;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function index(Request $request)
    {
        $projets = Projet::with(['structure', 'secteur', 'zoneLocalisation'])
            ->when($request->q, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('reference', 'like', "%{$request->q}%")
                      ->orWhere('intitule', 'like', "%{$request->q}%");
                });
            })
            ->when($request->secteur_id, fn ($q) => $q->where('secteur_id', $request->secteur_id))
            ->when($request->structure_id, fn ($q) => $q->where('structure_id', $request->structure_id))
            ->when($request->zone_localisation_id, fn ($q) => $q->where('zone_localisation_id', $request->zone_localisation_id))
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
        [$structures, $secteurs, $zones, $fichesPip, $axes] = $this->referenceData();
        return view('projets.create', compact('structures', 'secteurs', 'zones', 'fichesPip', 'axes'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $fichesPip = $data['fiches_pip'] ?? [];
        unset($data['fiches_pip']);

        $projet = Projet::create($data);
        if (!empty($fichesPip)) {
            $projet->fichesPip()->sync($fichesPip);
        }

        return redirect()->route('projets.show', $projet)->with('success', 'Projet créé avec succès.');
    }

    public function show(Projet $projet)
    {
        $projet->load([
            'structure', 'secteur', 'zoneLocalisation', 'axe.programme', 'fichesPip.programme',
            'activites.taches', 'activites.indicateurs', 'activites.composante',
            'financements.bailleur', 'financements.etat', 'financements.decaissements', 'financements.conventionFinancement',
            'depenses', 'rapports.utilisateur', 'piecesJustificatives.utilisateur',
            'composantes', 'risques', 'partiesPrenantes', 'cibles', 'etudes',
            'chargesRecurrentes', 'marches', 'objectifsSpecifiques',
        ]);
        return view('projets.show', compact('projet'));
    }

    public function edit(Projet $projet)
    {
        [$structures, $secteurs, $zones, $fichesPip, $axes] = $this->referenceData();
        $projet->load('fichesPip');
        return view('projets.edit', compact('projet', 'structures', 'secteurs', 'zones', 'fichesPip', 'axes'));
    }

    public function update(Request $request, Projet $projet)
    {
        $data = $this->validateData($request, $projet->id);
        $fichesPip = $data['fiches_pip'] ?? [];
        unset($data['fiches_pip']);

        $projet->update($data);
        $projet->fichesPip()->sync($fichesPip);

        return redirect()->route('projets.show', $projet)->with('success', 'Projet mis à jour avec succès.');
    }

    public function destroy(Projet $projet)
    {
        $projet->fichesPip()->detach();
        $projet->delete();
        return redirect()->route('projets.index')->with('success', 'Projet supprimé.');
    }

    private function referenceData(): array
    {
        return [
            Structure::orderBy('libelle')->get(),
            Secteur::orderBy('libelle')->get(),
            ZoneLocalisation::orderBy('type')->orderBy('libelle')->get(),
            FichePip::orderBy('nom')->get(),
            Axe::with('programme')->orderBy('libelle')->get(),
        ];
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
            'duree_prevue' => 'nullable|string|max:100',
            'action_pnd' => 'nullable|string|max:255',
            'programme_budgetaire' => 'nullable|string|max:255',
            'odd_concerne' => 'nullable|string|max:255',
            'domaine_impact_socio_eco' => 'nullable|string|max:255',
            'milieu_execution' => 'nullable|in:rural,urbain,inter_urbain,peri_urbain',
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
            'zone_localisation_id' => 'required|exists:zones_localisation,id',
            'axe_id' => 'nullable|exists:axes,id',
            'fiches_pip' => 'nullable|array',
            'fiches_pip.*' => 'exists:fiches_pip,id',
        ]);

        return $data;
    }
}
