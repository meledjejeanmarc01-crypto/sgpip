<?php

namespace App\Http\Controllers;

use App\Models\Bailleur;
use App\Models\Decaissement;
use App\Models\Depense;
use App\Models\Financement;
use App\Models\PieceJustificative;
use App\Models\Projet;
use App\Models\Rapport;
use App\Models\Secteur;
use App\Models\Structure;
use App\Models\ZoneLocalisation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projets' => Projet::count(),
            'projets_en_cours' => Projet::where('statut', 'en_cours')->count(),
            'projets_termines' => Projet::where('statut', 'termine')->count(),
            'projets_retardes' => Projet::where('statut', 'retarde')->count(),
            'total_structures' => Structure::count(),
            'total_bailleurs' => Bailleur::count(),
            'total_rapports' => Rapport::count(),
            'total_pieces' => PieceJustificative::count(),
            'montant_engage' => Financement::sum('montant_engage'),
            'montant_decaisse' => Decaissement::sum('montant'),
            'montant_depense' => Depense::sum('montant'),
            'avancement_moyen' => round(Projet::avg('avancement_physique') ?? 0, 1),
        ];

        $projetsParSecteur = Secteur::withCount('projets')->orderByDesc('projets_count')->get();

        $projetsParZone = ZoneLocalisation::query()
            ->withCount('projets')
            ->whereHas('projets')
            ->with('projets:id,intitule,reference,statut,avancement_physique,zone_localisation_id')
            ->get();

        $zonesCarte = ZoneLocalisation::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->withCount('projets')
            ->get();

        $zonesCarteData = $zonesCarte->map(function ($z) {
            return [
                'libelle' => $z->libelle,
                'type' => $z->type,
                'lat' => $z->latitude,
                'lng' => $z->longitude,
                'nb' => $z->projets_count,
            ];
        })->values();

        $projetsRecents = Projet::with(['structure', 'secteur', 'zoneLocalisation'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('stats', 'projetsParSecteur', 'projetsParZone', 'zonesCarte', 'zonesCarteData', 'projetsRecents'));
    }
}
