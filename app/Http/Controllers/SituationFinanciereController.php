<?php

namespace App\Http\Controllers;

use App\Models\Bailleur;
use App\Models\Decaissement;
use App\Models\Financement;
use App\Models\Depense;
use App\Models\Projet;

// Cahier des charges §9.5 : situation financière consolidée du PIP.
class SituationFinanciereController extends Controller
{
    public function index()
    {
        // Décaissements regroupés par projet (via le financement auquel ils se rattachent).
        $decaissementsParProjet = Decaissement::query()
            ->join('financements', 'financements.id', '=', 'decaissements.financement_id')
            ->selectRaw('financements.projet_id as projet_id, SUM(decaissements.montant) as total')
            ->groupBy('financements.projet_id')
            ->pluck('total', 'projet_id');

        $projets = Projet::with('secteur:id,libelle')
            ->withSum('financements', 'montant_engage')
            ->withSum('depenses', 'montant')
            ->orderBy('intitule')
            ->get()
            ->map(fn ($p) => (object) [
                'id' => $p->id,
                'reference' => $p->reference,
                'intitule' => $p->intitule,
                'secteur_id' => $p->secteur_id,
                'secteur' => $p->secteur?->libelle ?? 'Sans secteur',
                'cout' => (float) $p->cout_estimatif,
                'engage' => (float) $p->financements_sum_montant_engage,
                'decaisse' => (float) ($decaissementsParProjet[$p->id] ?? 0),
                'depense' => (float) $p->depenses_sum_montant,
            ]);

        $totaux = [
            'cout' => $projets->sum('cout'),
            'engage' => (float) Financement::sum('montant_engage'),
            'decaisse' => (float) Decaissement::sum('montant'),
            'depense' => (float) Depense::sum('montant'),
        ];
        $totaux['reste_a_decaisser'] = $totaux['engage'] - $totaux['decaisse'];
        $totaux['ecart_financement'] = $totaux['cout'] - $totaux['engage'];
        $totaux['taux_decaissement'] = $totaux['engage'] > 0 ? round($totaux['decaisse'] / $totaux['engage'] * 100, 1) : 0;
        $totaux['taux_depense'] = $totaux['decaisse'] > 0 ? round($totaux['depense'] / $totaux['decaisse'] * 100, 1) : 0;

        $parSecteur = $projets->groupBy('secteur')->map(fn ($g, $secteur) => (object) [
            'libelle' => $secteur,
            'projets' => $g->count(),
            'cout' => $g->sum('cout'),
            'engage' => $g->sum('engage'),
            'decaisse' => $g->sum('decaisse'),
            'depense' => $g->sum('depense'),
        ])->sortByDesc('cout')->values();

        $parBailleur = Bailleur::with('paysEtranger:id,libelle')
            ->withSum('financements', 'montant_engage')
            ->withSum('decaissements', 'montant')
            ->orderBy('nom')
            ->get()
            ->filter(fn ($b) => $b->financements_sum_montant_engage > 0 || $b->decaissements_sum_montant > 0)
            ->values();

        return view('situation-financiere.index', compact('totaux', 'parSecteur', 'parBailleur', 'projets'));
    }
}
