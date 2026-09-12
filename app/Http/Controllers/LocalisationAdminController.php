<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\District;
use App\Models\Localite;
use App\Models\Region;
use App\Models\SousPrefecture;
use Illuminate\Http\Request;

class LocalisationAdminController extends Controller
{
    /**
     * Page de gestion de la hiérarchie géographique.
     */
    public function index()
    {
        $districts = District::withCount('regions')->orderBy('nom')->get();
        $regions = Region::with('district')->orderBy('nom')->get();
        $departements = Departement::with('region')->orderBy('nom')->get();
        $sousPrefectures = SousPrefecture::with('departement')->orderBy('nom')->get();
        $communes = Commune::with('departement')->orderBy('nom')->get();
        $localites = Localite::with('commune.departement.region.district')->orderBy('nom')->get();

        return view('localisation.index', compact(
            'districts', 'regions', 'departements', 'sousPrefectures', 'communes', 'localites'
        ));
    }

    public function storeDistrict(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:districts,nom'],
            'description' => ['nullable', 'string'],
        ]);

        District::create($data);

        return back()->with('success', 'District ajouté avec succès.');
    }

    public function destroyDistrict(District $district)
    {
        $district->delete();

        return back()->with('success', 'District supprimé (ainsi que ses régions, départements, communes et localités).');
    }

    public function storeRegion(Request $request)
    {
        $data = $request->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Region::create($data);

        return back()->with('success', 'Région ajoutée avec succès.');
    }

    public function destroyRegion(Region $region)
    {
        $region->delete();

        return back()->with('success', 'Région supprimée.');
    }

    public function storeDepartement(Request $request)
    {
        $data = $request->validate([
            'region_id' => ['required', 'exists:regions,id'],
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Departement::create($data);

        return back()->with('success', 'Département ajouté avec succès.');
    }

    public function destroyDepartement(Departement $departement)
    {
        $departement->delete();

        return back()->with('success', 'Département supprimé.');
    }

    public function storeSousPrefecture(Request $request)
    {
        $data = $request->validate([
            'departement_id' => ['required', 'exists:departements,id'],
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        SousPrefecture::create($data);

        return back()->with('success', 'Sous-préfecture ajoutée avec succès.');
    }

    public function destroySousPrefecture(SousPrefecture $sousPrefecture)
    {
        $sousPrefecture->delete();

        return back()->with('success', 'Sous-préfecture supprimée.');
    }

    public function storeCommune(Request $request)
    {
        $data = $request->validate([
            'departement_id' => ['required', 'exists:departements,id'],
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Commune::create($data);

        return back()->with('success', 'Commune ajoutée avec succès.');
    }

    public function destroyCommune(Commune $commune)
    {
        $commune->delete();

        return back()->with('success', 'Commune supprimée.');
    }

    public function storeLocalite(Request $request)
    {
        $data = $request->validate([
            'commune_id' => ['required', 'exists:communes,id'],
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ], [], [
            'latitude' => 'latitude',
            'longitude' => 'longitude',
        ]);

        Localite::create($data);

        return back()->with('success', 'Localité ajoutée avec succès. Elle apparaîtra sur la carte dès qu\'un projet lui sera associé.');
    }

    public function destroyLocalite(Localite $localite)
    {
        $localite->delete();

        return back()->with('success', 'Localité supprimée.');
    }
}
