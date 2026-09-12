<?php

namespace App\Http\Controllers;

use App\Models\ZoneLocalisation;
use Illuminate\Http\Request;

class ZoneLocalisationController extends Controller
{
    public function index()
    {
        $zones = ZoneLocalisation::with('parent')->withCount('projets')->orderBy('type')->orderBy('libelle')->paginate(20);
        return view('zones.index', compact('zones'));
    }

    public function create()
    {
        $parents = ZoneLocalisation::orderBy('type')->orderBy('libelle')->get();
        return view('zones.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        ZoneLocalisation::create($data);
        return redirect()->route('zones.index')->with('success', 'Zone de localisation créée avec succès.');
    }

    public function show(ZoneLocalisation $zone)
    {
        $zone->load('parent', 'enfants', 'projets');
        return view('zones.show', compact('zone'));
    }

    public function edit(ZoneLocalisation $zone)
    {
        $parents = ZoneLocalisation::where('id', '!=', $zone->id)->orderBy('type')->orderBy('libelle')->get();
        return view('zones.edit', compact('zone', 'parents'));
    }

    public function update(Request $request, ZoneLocalisation $zone)
    {
        $data = $this->validateData($request);
        $zone->update($data);
        return redirect()->route('zones.index')->with('success', 'Zone de localisation mise à jour.');
    }

    public function destroy(ZoneLocalisation $zone)
    {
        if ($zone->projets()->exists() || $zone->enfants()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des projets ou sous-zones sont rattachés à cette zone.');
        }
        $zone->delete();
        return back()->with('success', 'Zone de localisation supprimée.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:district,region,departement,sous_prefecture,commune,localite',
            'libelle' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:zones_localisation,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);
    }
}
