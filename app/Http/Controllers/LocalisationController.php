<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Region;
use App\Models\Departement;
use App\Models\Commune;
use Illuminate\Http\JsonResponse;

class LocalisationController extends Controller
{
    /**
     * Retourne les régions d'un district.
     */
    public function regions(District $district): JsonResponse
    {
        return response()->json(
            $district->regions()
                ->orderBy('nom')
                ->get(['id', 'nom'])
        );
    }

    /**
     * Retourne les départements d'une région.
     */
    public function departements(Region $region): JsonResponse
    {
        return response()->json(
            $region->departements()
                ->orderBy('nom')
                ->get(['id', 'nom'])
        );
    }

    /**
     * Retourne les sous-préfectures d'un département.
     */
    public function sousPrefectures(Departement $departement): JsonResponse
    {
        return response()->json(
            $departement->sousPrefectures()
                ->orderBy('nom')
                ->get(['id', 'nom'])
        );
    }

    /**
     * Retourne les communes d'un département.
     */
    public function communes(Departement $departement): JsonResponse
    {
        return response()->json(
            $departement->communes()
                ->orderBy('nom')
                ->get(['id', 'nom'])
        );
    }

    /**
     * Retourne les localités d'une commune.
     */
    public function localites(Commune $commune): JsonResponse
    {
        return response()->json(
            $commune->localites()
                ->orderBy('nom')
                ->get([
                    'id',
                    'nom',
                    'latitude',
                    'longitude'
                ])
        );
    }
}