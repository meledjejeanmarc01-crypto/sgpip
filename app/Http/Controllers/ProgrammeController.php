<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Models\Structure;
use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    public function index(Request $request)
    {
        $programmes = Programme::with('structure')
            ->when($request->q, fn ($q) => $q->where('nom', 'like', "%{$request->q}%")->orWhere('code', 'like', "%{$request->q}%"))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();
        return view('programmes.index', compact('programmes'));
    }

    public function create()
    {
        $structures = Structure::orderBy('libelle')->get();
        return view('programmes.create', compact('structures'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Programme::create($data);
        return redirect()->route('programmes.index')->with('success', 'Programme créé avec succès.');
    }

    public function show(Programme $programme)
    {
        $programme->load(
            'structure',
            'axes.projets.secteur',
            'axes.projets.zonesExecution.localisation.niveau',
            'axes.projets.zonesExecution.localisation.region',
            'axes.projets.zonesExecution.paysEtranger',
            'fichesPip.projets.secteur',
            'fichesPip.projets.zonesExecution.localisation.niveau',
            'fichesPip.projets.zonesExecution.localisation.region',
            'fichesPip.projets.zonesExecution.paysEtranger',
        );

        // Un projet est rattaché au programme via son axe ou via une fiche PIP (les deux
        // chemins prévus par le cahier des charges) ; on fusionne et on déduplique.
        $projets = $programme->axes->flatMap->projets
            ->merge($programme->fichesPip->flatMap->projets)
            ->unique('id')
            ->sortBy('intitule')
            ->values();

        // Avancement moyen du programme = moyenne de l'avancement physique de tous ses projets.
        $avancementProgramme = $projets->count() ? round($projets->avg('avancement_physique'), 1) : null;

        // Avancement par région : un projet compte dans chaque région où il a une zone
        // d'exécution (un projet avec des zones dans 2 régions compte dans les deux).
        $projetsParRegion = collect();
        foreach ($projets as $projet) {
            $libellesRegions = $projet->zonesExecution
                ->map(function ($zone) {
                    if ($zone->paysEtranger) {
                        return "Hors Côte d'Ivoire";
                    }
                    $localisation = $zone->localisation;
                    if (!$localisation) {
                        return null;
                    }

                    return $localisation->region_effective?->libelle
                        ?? $localisation->libelle.' (échelle district)';
                })
                ->filter()
                ->unique();

            foreach ($libellesRegions as $libelle) {
                $projetsParRegion[$libelle] = ($projetsParRegion[$libelle] ?? collect())->push($projet);
            }
        }

        $statsParRegion = $projetsParRegion
            ->map(fn ($liste, $region) => [
                'region' => $region,
                'nb_projets' => $liste->count(),
                'avancement' => round($liste->avg('avancement_physique'), 1),
            ])
            ->sortByDesc('nb_projets')
            ->values();

        return view('programmes.show', compact('programme', 'projets', 'avancementProgramme', 'statsParRegion'));
    }

    public function edit(Programme $programme)
    {
        $structures = Structure::orderBy('libelle')->get();
        return view('programmes.edit', compact('programme', 'structures'));
    }

    public function update(Request $request, Programme $programme)
    {
        $data = $this->validateData($request);
        $programme->update($data);
        return redirect()->route('programmes.index')->with('success', 'Programme mis à jour.');
    }

    public function destroy(Programme $programme)
    {
        if ($programme->fichesPip()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des fiches PIP sont rattachées à ce programme.');
        }
        $programme->delete();
        return back()->with('success', 'Programme supprimé.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:255',
            'libelle' => 'nullable|string|max:255',
            'axe_strategique' => 'nullable|string|max:255',
            'code' => 'required|string|max:50|unique:programmes,code,'.$request->route('programme')?->id,
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'structure_id' => 'required|exists:structures,id',
        ]);
    }
}
