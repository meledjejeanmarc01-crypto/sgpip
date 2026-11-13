@extends('layouts.app')
@section('page-title', 'Situation financière consolidée du PIP')
@section('content')
@php
    $f = fn ($v) => number_format((float) $v, 0, ',', ' ');
    $pct = fn ($a, $b) => $b > 0 ? number_format($a / $b * 100, 1, ',', ' ') . ' %' : '—';
@endphp

<div class="row g-3 mb-3">
    @foreach([
        ['Coût total des projets', $totaux['cout'], 'bi-kanban'],
        ['Montant financé (financements)', $totaux['engage'], 'bi-cash-coin'],
        ['Montant décaissé', $totaux['decaisse'], 'bi-arrow-down-circle'],
        ['Montant dépensé', $totaux['depense'], 'bi-receipt'],
    ] as [$label, $valeur, $icone])
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3 h-100">
                <div class="text-muted small"><i class="bi {{ $icone }} me-1"></i>{{ $label }}</div>
                <div class="fs-5 fw-bold">{{ $f($valeur) }} <span class="fs-6 fw-normal">FCFA</span></div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3"><div class="card card-stat p-3 h-100"><div class="text-muted small">Taux de décaissement (décaissé / financé)</div><div class="fs-5 fw-bold">{{ number_format($totaux['taux_decaissement'], 1, ',', ' ') }} %</div></div></div>
    <div class="col-6 col-lg-3"><div class="card card-stat p-3 h-100"><div class="text-muted small">Taux de dépense (dépensé / décaissé)</div><div class="fs-5 fw-bold">{{ number_format($totaux['taux_depense'], 1, ',', ' ') }} %</div></div></div>
    <div class="col-6 col-lg-3"><div class="card card-stat p-3 h-100"><div class="text-muted small">Reste à décaisser</div><div class="fs-5 fw-bold">{{ $f($totaux['reste_a_decaisser']) }} <span class="fs-6 fw-normal">FCFA</span></div></div></div>
    <div class="col-6 col-lg-3"><div class="card card-stat p-3 h-100"><div class="text-muted small">Écart de financement (coût − financé)</div><div class="fs-5 fw-bold">{{ $f($totaux['ecart_financement']) }} <span class="fs-6 fw-normal">FCFA</span></div></div></div>
</div>

<div class="card card-stat p-3 mb-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-grid me-1"></i>Par secteur</h6>
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead><tr><th>Secteur</th><th class="text-end">Projets</th><th class="text-end">Coût</th><th class="text-end">Financé</th><th class="text-end">Décaissé</th><th class="text-end">Dépensé</th><th class="text-end">Décaissé / financé</th></tr></thead>
            <tbody>
            @forelse($parSecteur as $s)
                <tr><td>{{ $s->libelle }}</td><td class="text-end">{{ $s->projets }}</td><td class="text-end">{{ $f($s->cout) }}</td><td class="text-end">{{ $f($s->engage) }}</td><td class="text-end">{{ $f($s->decaisse) }}</td><td class="text-end">{{ $f($s->depense) }}</td><td class="text-end">{{ $pct($s->decaisse, $s->engage) }}</td></tr>
            @empty
                <tr><td colspan="7" class="text-muted">Aucune donnée.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card card-stat p-3 mb-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-bank me-1"></i>Par bailleur</h6>
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead><tr><th>Bailleur</th><th>Pays</th><th class="text-end">Financé</th><th class="text-end">Décaissé</th><th class="text-end">Reste à décaisser</th><th class="text-end">Décaissé / financé</th></tr></thead>
            <tbody>
            @forelse($parBailleur as $b)
                @php $eng = (float) $b->financements_sum_montant_engage; $dec = (float) $b->decaissements_sum_montant; @endphp
                <tr><td>{{ $b->nom }}</td><td>{{ $b->paysEtranger->libelle ?? '—' }}</td><td class="text-end">{{ $f($eng) }}</td><td class="text-end">{{ $f($dec) }}</td><td class="text-end">{{ $f($eng - $dec) }}</td><td class="text-end">{{ $pct($dec, $eng) }}</td></tr>
            @empty
                <tr><td colspan="6" class="text-muted">Aucun financement enregistré.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card card-stat p-3">
    <h6 class="fw-bold mb-3"><i class="bi bi-kanban me-1"></i>Par projet</h6>
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead><tr><th>Projet</th><th>Secteur</th><th class="text-end">Coût</th><th class="text-end">Financé</th><th class="text-end">Décaissé</th><th class="text-end">Dépensé</th><th class="text-end">Décaissé / financé</th></tr></thead>
            <tbody>
            @forelse($projets as $p)
                <tr><td><a href="{{ route('projets.show', $p->id) }}" class="text-decoration-none">{{ $p->reference }} — {{ $p->intitule }}</a></td><td>{{ $p->secteur }}</td><td class="text-end">{{ $f($p->cout) }}</td><td class="text-end">{{ $f($p->engage) }}</td><td class="text-end">{{ $f($p->decaisse) }}</td><td class="text-end">{{ $f($p->depense) }}</td><td class="text-end">{{ $pct($p->decaisse, $p->engage) }}</td></tr>
            @empty
                <tr><td colspan="7" class="text-muted">Aucun projet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
