@extends('layouts.app')
@section('page-title', "Détail de la zone d'exécution")
@section('content')
<div class="card card-stat p-4 mb-3">
    <h5 class="fw-bold">{{ $zone->libelle }}</h5>
    <p class="text-muted mb-1">Pays : {{ $zone->paysEtranger?->libelle ?? $zone->pays ?? '—' }}</p>
    <p class="text-muted mb-1">Statut : {{ ucfirst($zone->statut ?? 'actif') }}</p>
    @if($zone->description)
        <p class="mb-0">{{ $zone->description }}</p>
    @endif
</div>
<div class="card card-stat p-3 mb-3">
    <h6 class="fw-bold">Localisation</h6>
    @if($zone->localisation)
        <p class="small mb-1"><span class="badge bg-secondary">{{ $zone->localisation->niveau->libelle }}</span> {{ $zone->localisation->chemin }}</p>
    @else
        <p class="small text-muted mb-0">Aucune localisation (zone hors Côte d'Ivoire ou non encore rattachée).</p>
    @endif
</div>
<div class="card card-stat p-3">
    <h6 class="fw-bold">Projets localisés ici ({{ $zone->projets->count() }})</h6>
    <ul class="list-unstyled small mb-0">
        @forelse($zone->projets as $p)
            <li class="border-bottom py-1"><a href="{{ route('projets.show', $p) }}">{{ $p->intitule }}</a></li>
        @empty
            <li class="text-muted">Aucun projet rattaché.</li>
        @endforelse
    </ul>
</div>
@endsection
