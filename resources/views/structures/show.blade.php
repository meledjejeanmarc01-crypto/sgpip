@extends('layouts.app')
@section('page-title', 'Détail de la structure')
@section('content')
<div class="card card-stat p-4 mb-3">
    <h5 class="fw-bold">{{ $structure->libelle }} @if($structure->sigle)<span class="text-muted">({{ $structure->sigle }})</span>@endif</h5>
    <p class="text-muted mb-1">Type : {{ $structure->typeStructure->libelle ?? '—' }}</p>
    <p class="text-muted mb-1">Adresse : {{ $structure->adresse ?? '—' }}</p>
    <p class="text-muted mb-0">Téléphone : {{ $structure->telephone ?? '—' }}</p>
</div>
<div class="row g-3">
    <div class="col-md-6">
        <div class="card card-stat p-3">
            <h6 class="fw-bold">Projets rattachés ({{ $structure->projets->count() }})</h6>
            <ul class="list-unstyled small mb-0">
                @foreach($structure->projets as $p)
                    <li class="border-bottom py-1"><a href="{{ route('projets.show', $p) }}">{{ $p->intitule }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stat p-3">
            <h6 class="fw-bold">Programmes pilotés ({{ $structure->programmes->count() }})</h6>
            <ul class="list-unstyled small mb-0">
                @foreach($structure->programmes as $p)
                    <li class="border-bottom py-1"><a href="{{ route('programmes.show', $p) }}">{{ $p->nom }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
