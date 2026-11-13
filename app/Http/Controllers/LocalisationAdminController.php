<?php

namespace App\Http\Controllers;

use App\Models\Localisation;
use App\Models\NiveauLocalisation;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LocalisationAdminController extends Controller
{
    /**
     * Page de gestion de la hiérarchie géographique :
     * District -> Région -> Département -> Commune -> Sous-préfecture -> Village
     * (une seule table "localisations", chaque ligne porte directement une colonne
     * par niveau d'ancêtre : district_id, region_id, departement_id, commune_id,
     * sous_prefecture_id).
     */
    public function index(Request $request)
    {
        $niveaux = NiveauLocalisation::orderBy('id')->get();

        $localisations = Localisation::query()
            ->with('niveau', 'district', 'region', 'departement', 'commune', 'sousPrefecture', 'zoneExecution')
            ->when($request->filled('niveau_id'), fn ($q) => $q->where('niveau_id', $request->niveau_id))
            ->when($request->filled('q'), fn ($q) => $q->where('libelle', 'like', '%'.$request->q.'%'))
            ->orderBy('niveau_id')
            ->orderBy('libelle')
            ->paginate(25)
            ->withQueryString();

        return view('localisation.index', compact('niveaux', 'localisations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'niveau_id' => ['required', 'exists:niveau_localisations,id'],
            'parent_id' => ['nullable', 'exists:localisations,id'],
            'libelle' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:localisations,code'],
            'description' => ['nullable', 'string'],
            'milieu' => ['nullable', 'in:urbain,rural'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $niveauId = (int) $data['niveau_id'];
        $parent = null;

        if ($niveauId === NiveauLocalisation::DISTRICT) {
            // RG45 : un district n'a pas d'ancêtre.
            if (!empty($data['parent_id'])) {
                throw ValidationException::withMessages(['parent_id' => "Un district n'a pas d'ancêtre."]);
            }
        } else {
            // RG44/RG45 : toute autre localisation a un ancêtre immédiat du niveau juste au-dessus.
            if (empty($data['parent_id'])) {
                throw ValidationException::withMessages(['parent_id' => 'Cette localisation doit avoir une localisation parente.']);
            }
            $parent = Localisation::with('niveau')->findOrFail($data['parent_id']);
            if ($parent->niveau_id !== $niveauId - 1) {
                $attendu = NiveauLocalisation::find($niveauId - 1)?->libelle;
                throw ValidationException::withMessages(['parent_id' => "Le parent doit être du niveau « {$attendu} »."]);
            }
        }

        $colonneDuParent = $niveauId > 1
            ? Localisation::niveauVersColonne($niveauId - 1)
            : null;

        $existeDejaExiste = Localisation::where('niveau_id', $niveauId)
            ->where('libelle', $data['libelle'])
            ->when($colonneDuParent, fn ($q) => $q->where($colonneDuParent, $parent?->id))
            ->exists();
        if ($existeDejaExiste) {
            throw ValidationException::withMessages(['libelle' => 'Cette localisation existe déjà sous le même parent.']);
        }

        Localisation::creerSous($niveauId, $parent, [
            'libelle' => $data['libelle'],
            'code' => $data['code'] ?? null,
            'description' => $data['description'] ?? null,
            'milieu' => $data['milieu'] ?? null,
            'localisation_parent_id' => $parent?->id,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);

        return back()->with('success', 'Localisation ajoutée avec succès.');
    }

    public function destroy(Localisation $localisation)
    {
        // RG47 : une localisation qui a des enfants ou une zone d'exécution ne peut pas être supprimée.
        if ($localisation->aDesEnfants()) {
            return back()->with('error', 'Impossible de supprimer : cette localisation a des localisations enfants.');
        }
        if ($localisation->zoneExecution()->exists()) {
            return back()->with('error', "Impossible de supprimer : une zone d'exécution est rattachée à cette localisation.");
        }

        $localisation->delete();

        return back()->with('success', 'Localisation supprimée.');
    }
}
