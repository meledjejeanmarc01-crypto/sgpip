@extends('layouts.app')
@section('page-title', 'Détail de la zone')
@section('content')
<div class="card card-stat p-4 mb-3">
    <h5 class="fw-bold">{{ $zone->libelle }} <span class="badge bg-light text-dark border">{{ str_replace('_',' ',$zone->type) }}</span></h5>
    <p class="text-muted mb-0">Zone parente : {{ $zone->parent->libelle ?? '—' }}</p>
</div>
<div class="card card-stat p-3">
    <h6 class="fw-bold">Projets localisés ici ({{ $zone->projets->count() }})</h6>
    <ul class="list-unstyled small mb-0">
        @foreach($zone->projets as $p)
            <li class="border-bottom py-1"><a href="{{ route('projets.show', $p) }}">{{ $p->intitule }}</a></li>
        @endforeach
    </ul>
</div>
@endsection
