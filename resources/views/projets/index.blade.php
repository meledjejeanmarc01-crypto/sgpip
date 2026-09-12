@extends('layouts.app')
@section('page-title', 'Projets')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Projets d'investissement public</h5>
    @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
        <a href="{{ route('projets.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouveau projet</a>
    @endif
</div>

<form class="card card-stat p-3 mb-3">
    <div class="row g-2">
        <div class="col-md-3"><input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Référence ou intitulé..."></div>
        <div class="col-md-2">
            <select name="secteur_id" class="form-select form-select-sm">
                <option value="">Tous les secteurs</option>
                @foreach($secteurs as $s)<option value="{{ $s->id }}" @selected(request('secteur_id')==$s->id)>{{ $s->libelle }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="structure_id" class="form-select form-select-sm">
                <option value="">Toutes les structures</option>
                @foreach($structures as $s)<option value="{{ $s->id }}" @selected(request('structure_id')==$s->id)>{{ $s->sigle ?? $s->libelle }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="zone_localisation_id" class="form-select form-select-sm">
                <option value="">Toutes les zones</option>
                @foreach($zones as $z)<option value="{{ $z->id }}" @selected(request('zone_localisation_id')==$z->id)>{{ $z->libelle }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="statut" class="form-select form-select-sm">
                <option value="">Tous les statuts</option>
                @foreach(['planifie'=>'Planifié','en_cours'=>'En cours','termine'=>'Terminé','suspendu'=>'Suspendu','retarde'=>'Retardé'] as $val=>$label)
                    <option value="{{ $val }}" @selected(request('statut')==$val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1"><button class="btn btn-sm btn-outline-secondary w-100"><i class="bi bi-search"></i></button></div>
    </div>
</form>

<div class="row g-3">
    @forelse($projets as $projet)
    <div class="col-md-6 col-lg-4">
        <div class="card card-stat p-3 h-100">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted small">{{ $projet->reference }}</span>
                <span class="badge badge-statut-{{ $projet->statut }}">{{ str_replace('_',' ',$projet->statut) }}</span>
            </div>
            <h6 class="fw-bold"><a href="{{ route('projets.show', $projet) }}" class="text-decoration-none text-dark">{{ $projet->intitule }}</a></h6>
            <div class="small text-muted mb-2">
                <div><i class="bi bi-building"></i> {{ $projet->structure->libelle ?? '—' }}</div>
                <div><i class="bi bi-grid"></i> {{ $projet->secteur->libelle ?? '—' }}</div>
                <div><i class="bi bi-geo-alt"></i> {{ $projet->zoneLocalisation->libelle ?? '—' }}</div>
            </div>
            <div class="progress mb-1" style="height:6px;"><div class="progress-bar bg-success" style="width: {{ $projet->avancement_physique }}%"></div></div>
            <div class="small text-muted mb-2">Avancement physique : {{ $projet->avancement_physique }}%</div>
            <div class="fw-semibold small">{{ number_format($projet->cout_estimatif,0,',',' ') }} FCFA</div>
        </div>
    </div>
    @empty
    <div class="col-12"><div class="card card-stat p-4 text-center text-muted">Aucun projet ne correspond aux critères.</div></div>
    @endforelse
</div>
<div class="mt-3">{{ $projets->links() }}</div>
@endsection
