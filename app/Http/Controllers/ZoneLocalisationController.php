<?php

namespace App\Http\Controllers;

use App\Models\NiveauLocalisation;
use App\Models\PaysEtranger;
use App\Models\ZoneLocalisation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// ZONE D'EXECUTION — cahier : "id, libellé, pays, description, statut, localisation_id".
// La hiérarchie district/région/.../village est gérée par LocalisationAdminController.
class ZoneLocalisationController extends Controller
{
    public function index(Request $request)
    {
        $zones = ZoneLocalisation::with('paysEtranger', 'localisation.niveau', 'localisation.district', 'localisation.region', 'localisation.departement', 'localisation.commune', 'localisation.sousPrefecture')
            ->withCount('projets')
            ->when($request->filled('q'), fn ($q) => $q->where('libelle', 'like', '%'.$request->q.'%'))
            ->when($request->niveau_id === 'hors_ci', fn ($q) => $q->whereNotNull('pays_etranger_id'))
            ->when($request->filled('niveau_id') && $request->niveau_id !== 'hors_ci',
                fn ($q) => $q->whereHas('localisation', fn ($l) => $l->where('niveau_id', $request->niveau_id)))
            ->orderBy('libelle')
            ->paginate(20)
            ->withQueryString();

        $niveaux = NiveauLocalisation::orderBy('id')->get();

        return view('zones.index', compact('zones', 'niveaux'));
    }

    public function create()
    {
        $paysEtrangers = PaysEtranger::orderBy('libelle')->get();
        $niveaux = NiveauLocalisation::orderBy('id')->get();

        return view('zones.create', compact('paysEtrangers', 'niveaux'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        ZoneLocalisation::create($data);

        return redirect()->route('zones.index')->with('success', "Zone d'exécution créée avec succès.");
    }

    public function show(ZoneLocalisation $zone)
    {
        $zone->load('paysEtranger', 'localisation.niveau', 'localisation.district', 'localisation.region', 'localisation.departement', 'localisation.commune', 'localisation.sousPrefecture', 'projets');

        return view('zones.show', compact('zone'));
    }

    public function edit(ZoneLocalisation $zone)
    {
        $paysEtrangers = PaysEtranger::orderBy('libelle')->get();
        $niveaux = NiveauLocalisation::orderBy('id')->get();
        $zone->load('localisation');

        return view('zones.edit', compact('zone', 'paysEtrangers', 'niveaux'));
    }

    public function update(Request $request, ZoneLocalisation $zone)
    {
        $data = $this->validateData($request, $zone);
        $zone->update($data);

        return redirect()->route('zones.index')->with('success', "Zone d'exécution mise à jour.");
    }

    public function destroy(ZoneLocalisation $zone)
    {
        // RG46 : une zone rattachée à au moins un projet ne peut pas être supprimée.
        if ($zone->projets()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des projets sont rattachés à cette zone.');
        }
        $zone->delete();

        return back()->with('success', "Zone d'exécution supprimée.");
    }

    private function validateData(Request $request, ?ZoneLocalisation $zone = null): array
    {
        // Une zone hors CI (pays étranger) n'a pas de localisation : on ignore une éventuelle sélection.
        if ($request->filled('pays_etranger_id')) {
            $request->merge(['localisation_id' => null]);
        }

        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'pays' => 'nullable|string|max:255',
            'pays_etranger_id' => 'nullable|exists:pays_etrangers,id',
            'description' => 'nullable|string',
            'statut' => ['required', Rule::in(['actif', 'inactif'])],
            // RG42 : une zone en Côte d'Ivoire a une localisation (une seule zone par localisation).
            // Une zone hors CI (pays étranger, RG48) n'en a pas.
            'localisation_id' => [
                'nullable',
                'required_without:pays_etranger_id',
                'exists:localisations,id',
                Rule::unique('zones_localisation', 'localisation_id')->ignore($zone?->id),
            ],
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], [
            'localisation_id.required_without' => "Choisis une localisation, ou un pays étranger pour une zone hors Côte d'Ivoire.",
            'localisation_id.unique' => "Cette localisation a déjà une zone d'exécution.",
        ]);

        return $data;
    }
}
