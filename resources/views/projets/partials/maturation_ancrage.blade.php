{{-- Fiche de maturation, étape 2 : sections 5 à 12 --}}
@php
    $dash = fn ($v) => filled($v) ? $v : '—';
    $libMilieux = ['rural' => 'Rural', 'urbain' => 'Urbain', 'inter_urbain' => 'Inter-urbain', 'peri_urbain' => 'Péri-urbain'];
    $milieux = $projet->milieuxExecution->pluck('categorie')->map(fn ($m) => $libMilieux[$m] ?? $m)->all();

    // Section 12 : zones classées par niveau (district, région, ...), à partir de la localisation de chaque zone.
    $niveaux = [1 => 'Districts', 2 => 'Régions', 3 => 'Départements', 4 => 'Communes', 5 => 'Sous-préfectures', 6 => 'Villages'];
    $colonnesAncetres = [1 => 'district_id', 2 => 'region_id', 3 => 'departement_id', 4 => 'commune_id', 5 => 'sous_prefecture_id'];
    $parNiveau = array_fill_keys(array_keys($niveaux), []);
    $horsCi = [];
    $ancetresIds = [];
    foreach ($projet->zonesExecution as $zone) {
        $loc = $zone->localisation;
        if ($loc) {
            foreach ($colonnesAncetres as $col) { if ($loc->{$col}) { $ancetresIds[] = $loc->{$col}; } }
        }
    }
    $ancetres = \App\Models\Localisation::whereIn('id', array_unique($ancetresIds))->get()->keyBy('id');
    foreach ($projet->zonesExecution as $zone) {
        $loc = $zone->localisation;
        if (! $loc) {
            $pays = optional($zone->paysEtranger)->libelle;
            $horsCi[] = $zone->libelle.($pays ? ' ('.$pays.')' : '');
            continue;
        }
        if (isset($parNiveau[$loc->niveau_id])) { $parNiveau[$loc->niveau_id][] = $loc->libelle; }
        foreach ($colonnesAncetres as $niveau => $col) {
            if ($loc->{$col} && $loc->{$col} != $loc->id && isset($ancetres[$loc->{$col}])) {
                $parNiveau[$niveau][] = $ancetres[$loc->{$col}]->libelle;
            }
        }
    }
@endphp
<div class="card card-stat p-4 mb-3">
    <h6 class="fw-bold mb-3">Rattachement et ancrage stratégique</h6>
    <div class="row g-3">
        <div class="col-md-6"><div class="small text-muted">Programme(s) et action(s) budgétaire</div><div style="white-space: pre-line;">{{ $dash($projet->programme_budgetaire) }}</div></div>
        <div class="col-md-6"><div class="small text-muted">Action(s) PND (arrimage au cadre de résultats)</div><div>{{ $dash(optional($projet->actionPnd)->libelle) }}</div></div>
        <div class="col-md-6">
            <div class="small text-muted">Projet issu du portefeuille projet/programme du PND ?</div>
            <div>@if(is_null($projet->appartient_portefeuille_pnd)) — @else <span class="badge {{ $projet->appartient_portefeuille_pnd ? 'bg-success' : 'bg-secondary' }}">{{ $projet->appartient_portefeuille_pnd ? 'Oui' : 'Non' }}</span> @endif</div>
        </div>
        <div class="col-md-6"><div class="small text-muted">Projet(s) identifié(s)</div><div style="white-space: pre-line;">{{ $dash($projet->portefeuille_pnd_projets) }}</div></div>
        <div class="col-md-6"><div class="small text-muted">Domaine d'impact socio-économique</div><div>{{ $dash($projet->domaine_impact_socio_eco) }}</div></div>
        <div class="col-md-6"><div class="small text-muted">Milieu d'exécution</div><div>{{ $milieux ? implode(', ', $milieux) : '—' }}</div></div>
        <div class="col-md-6"><div class="small text-muted">Document de politique / stratégie (source)</div><div>{{ $dash($projet->ancrage_document_source) }}</div></div>
        <div class="col-md-6"><div class="small text-muted">Objectif(s) et/ou stratégie(s) concerné(s)</div><div style="white-space: pre-line;">{{ $dash($projet->ancrage_objectifs_strategies) }}</div></div>
        <div class="col-12"><div class="small text-muted">Objectifs de développement durable (ODD) concernés</div><div style="white-space: pre-line;">{{ $dash($projet->odd_concerne) }}</div></div>
    </div>

    <h6 class="fw-bold mt-4 mb-3">Zone d'exécution géographique</h6>
    <div class="row g-2">
        @foreach($niveaux as $n => $lib)
            <div class="col-md-6"><span class="text-muted small">{{ $lib }} :</span> {{ count($parNiveau[$n]) ? implode(', ', array_unique($parNiveau[$n])) : '—' }}</div>
        @endforeach
        <div class="col-md-6"><span class="text-muted small">Hors Côte d'Ivoire :</span> {{ count($horsCi) ? implode(', ', $horsCi) : '—' }}</div>
    </div>
</div>
