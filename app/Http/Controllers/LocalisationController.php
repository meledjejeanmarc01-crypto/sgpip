<?php

namespace App\Http\Controllers;

use App\Models\Localisation;
use App\Models\NiveauLocalisation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// API JSON pour les listes déroulantes : localisations d'un niveau donné.
// Sert au choix du parent (page Localisation) et de la localisation d'une zone d'exécution.
class LocalisationController extends Controller
{
    public function parNiveau(Request $request, NiveauLocalisation $niveau): JsonResponse
    {
        $liste = Localisation::query()
            ->with('district', 'region', 'departement', 'commune', 'sousPrefecture')
            ->where('niveau_id', $niveau->id)
            // ?libres=1 : uniquement les localisations sans zone d'exécution (RG42),
            // en gardant celle de la zone en cours de modification (?except_zone=ID).
            ->when($request->boolean('libres'), function ($q) use ($request) {
                $q->where(function ($w) use ($request) {
                    $w->whereDoesntHave('zoneExecution');
                    if ($request->filled('except_zone')) {
                        $w->orWhereHas('zoneExecution', fn ($z) => $z->where('id', $request->except_zone));
                    }
                });
            })
            ->orderBy('libelle')
            ->get()
            ->map(fn ($l) => [
                'id' => $l->id,
                'libelle' => $l->libelle,
                'label' => $l->libelle.($l->parent_immediat ? ' — '.$l->parent_immediat->libelle : ''),
            ]);

        return response()->json($liste);
    }
}
