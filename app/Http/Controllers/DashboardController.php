<?php

namespace App\Http\Controllers;

use App\Models\Bailleur;
use App\Models\Document;
use App\Models\Decaissement;
use App\Models\Depense;
use App\Models\Financement;
use App\Models\Projet;
use App\Models\Rapport;
use App\Models\Secteur;
use App\Models\Structure;
use App\Models\ZoneLocalisation;

class DashboardController extends Controller
{
    public function index()
    {
        $coutTotal = (float) Projet::sum('cout_estimatif');
        $montantDecaisseTotal = (float) Decaissement::sum('montant');

        // Section 9.2 du cahier des charges : indicateurs du tableau de bord.
        $stats = [
            'total_projets' => Projet::count(),
            'projets_en_cours' => Projet::where('statut', 'en_cours')->count(),
            'projets_termines' => Projet::where('statut', 'termine')->count(),
            'projets_retardes' => Projet::where('statut', 'retarde')->count(),
            'projets_suspendus' => Projet::where('statut', 'suspendu')->count(),
            'projets_planifies' => Projet::where('statut', 'planifie')->count(),
            'total_structures' => Structure::count(),
            'total_bailleurs' => Bailleur::count(),
            'total_rapports' => Rapport::count(),
            'total_documents' => Document::count(),
            'montant_engage' => Financement::sum('montant_engage'),
            'montant_decaisse' => Decaissement::sum('montant'),
            'montant_depense' => Depense::sum('montant'),
            'avancement_physique_moyen' => round(Projet::avg('avancement_physique') ?? 0, 1),
            // Taux d'avancement financier = montant décaissé / coût estimatif total, sur l'ensemble des projets.
            'avancement_financier_moyen' => $coutTotal > 0 ? round($montantDecaisseTotal / $coutTotal * 100, 1) : 0,
            'montant_total_projets' => $coutTotal,
        ];

        // Statistiques par secteur et par zone d'exécution (section 9.2).
        $projetsParSecteur = Secteur::withCount('projets')->orderByDesc('projets_count')->get();

        // RG41 : Projet <-> Zone d'exécution est une relation plusieurs-à-plusieurs.
        $projetsParZone = ZoneLocalisation::query()
            ->withCount('projets')
            ->whereHas('projets')
            ->with(['projets' => function ($q) {
                $q->select('projets.id', 'intitule', 'reference', 'statut', 'avancement_physique');
            }])
            ->get();

        $projetsParZoneStat = ZoneLocalisation::withCount('projets')
            ->withSum('projets', 'cout_estimatif')
            ->withAvg('projets', 'avancement_physique')
            ->orderByDesc('projets_count')
            ->take(6)
            ->get();

        // Carte : toutes les zones d'exécution qui ont au moins un projet, avec le nombre
        // de projets, leur montant total (somme du coût estimatif) et leur avancement
        // physique moyen, quelles que soient les coordonnées déjà saisies sur la zone
        // (repli sur celles de sa localisation).
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

        // Index de tous les projets pour le filtre du tableau de bord (secteur, zone, statut) :
        // en sélectionnant un projet, la carte se centre sur la ou les zones où il s'exécute.
        $projetsIndex = Projet::with('secteur:id,libelle', 'zonesExecution:id,libelle')
            ->latest()
            ->get(['id', 'intitule', 'reference', 'statut', 'secteur_id', 'cout_estimatif', 'avancement_physique'])
            ->map(fn ($p) => [
                'id' => $p->id,
                'intitule' => $p->intitule,
                'reference' => $p->reference,
                'statut' => $p->statut,
                'secteur_id' => $p->secteur_id,
                'secteur' => $p->secteur?->libelle,
                'cout' => (float) $p->cout_estimatif,
                'avancement' => (float) $p->avancement_physique,
                'zone_ids' => $p->zonesExecution->pluck('id')->values(),
                'zones' => $p->zonesExecution->pluck('libelle')->implode(', '),
                'url' => route('projets.show', $p),
            ])
            ->values();

        // Listes des combo box (Top secteurs et Statistiques par zone) : secteurs et zones ayant des projets.
        $zonesFiltre = $zonesCarte
            ->map(fn ($z) => ['id' => $z->id, 'libelle' => $z->libelle])
            ->sortBy('libelle', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        $secteursFiltre = $projetsParSecteur
            ->where('projets_count', '>', 0)
            ->map(fn ($s) => ['id' => $s->id, 'libelle' => $s->libelle])
            ->values();

        $projetsRecents = Projet::with(['structure', 'secteur', 'zonesExecution'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('stats', 'projetsParSecteur', 'projetsParZone', 'projetsParZoneStat', 'zonesCarte', 'zonesCarteData', 'projetsRecents', 'projetsIndex', 'zonesFiltre', 'secteursFiltre'));
    }
}
