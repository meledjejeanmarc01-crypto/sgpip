@extends('layouts.app')
@section('page-title', 'Détail du programme')
@section('content')
<div class="card card-stat p-4 mb-3">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h5 class="fw-bold">{{ $programme->nom }} <span class="text-muted">({{ $programme->code }})</span></h5>
            <p class="text-muted mb-1">{{ $programme->libelle }}</p>
            <p class="text-muted mb-1">Axe stratégique : {{ $programme->axe_strategique ?: '—' }}</p>
            <p class="text-muted mb-1">Structure pilote : {{ $programme->structure->libelle ?? '—' }}</p>
            <p class="text-muted mb-0">Période : {{ optional($programme->date_debut)->format('d/m/Y') }} - {{ optional($programme->date_fin)->format('d/m/Y') }}</p>
        </div>
        <div class="text-center">
            <div class="text-muted small">Avancement moyen du programme</div>
            <div class="fs-3 fw-bold">{{ $avancementProgramme !== null ? number_format($avancementProgramme, 1, ',', '') : '—' }}{{ $avancementProgramme !== null ? '%' : '' }}</div>
            <div class="text-muted small">{{ $projets->count() }} projet(s) rattaché(s)</div>
        </div>
    </div>
</div>
<div class="card card-stat p-3 mb-3">
    <h6 class="fw-bold mb-3">Axes du programme ({{ $programme->axes->count() }})</h6>
    @if(auth()->user()->peutModifier('axes'))
    <form method="POST" action="{{ route('axes.store', $programme) }}" class="row g-2 mb-3">
        @csrf
        <div class="col-md-8"><input type="text" name="libelle" class="form-control form-control-sm" placeholder="Libellé de l'axe" required></div>
        <div class="col-md-2"><button class="btn btn-sm btn-brand w-100">Ajouter</button></div>
    </form>
    @endif
    <ul class="list-group list-group-flush">
        @forelse($programme->axes as $axe)
        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
            <span>{{ $axe->libelle }}</span>
            @if(auth()->user()->peutModifier('axes'))
            <div>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editAxe{{ $axe->id }}"><i class="bi bi-pencil"></i></button>
                <form action="{{ route('axes.destroy', $axe) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet axe ?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </div>
            <div class="modal fade" id="editAxe{{ $axe->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('axes.update', $axe) }}">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h6 class="modal-title fw-bold">Modifier l'axe</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="libelle" value="{{ $axe->libelle }}" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button class="btn btn-brand">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </li>
        @empty
        <li class="list-group-item px-0 text-muted">Aucun axe défini pour ce programme.</li>
        @endforelse
    </ul>
</div>
<div class="card card-stat p-3 mb-3">
    <h6 class="fw-bold mb-3">Projets rattachés ({{ $projets->count() }})</h6>
    @if($projets->isEmpty())
        <p class="text-muted mb-0">Aucun projet rattaché à ce programme pour le moment (via un axe ou une fiche PIP).</p>
    @else
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr><th>Projet</th><th>Secteur</th><th>Statut</th><th style="width:220px;">Avancement physique</th></tr>
                </thead>
                <tbody>
                @foreach($projets as $projet)
                    <tr>
                        <td><a href="{{ route('projets.show', $projet) }}" class="text-decoration-none">{{ $projet->intitule }}</a></td>
                        <td>{{ $projet->secteur->libelle ?? '—' }}</td>
                        <td><span class="badge badge-statut-{{ $projet->statut }}">{{ str_replace('_',' ',$projet->statut) }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-fill" style="height:8px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ min($projet->avancement_physique, 100) }}%; background-color:#F4992A;"></div>
                                </div>
                                <span class="small fw-semibold" style="width:3rem;">{{ $projet->avancement_physique }}%</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<div class="card card-stat p-3 mb-3">
    <h6 class="fw-bold mb-3">Avancement par région</h6>
    @if($statsParRegion->isEmpty())
        <p class="text-muted mb-0">Aucune zone d'exécution renseignée sur les projets de ce programme.</p>
    @else
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead><tr><th>Région</th><th>Projets</th><th style="width:220px;">Avancement moyen</th></tr></thead>
                <tbody>
                @foreach($statsParRegion as $ligne)
                    <tr>
                        <td>{{ $ligne['region'] }}</td>
                        <td>{{ $ligne['nb_projets'] }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-fill" style="height:8px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ min($ligne['avancement'], 100) }}%; background-color:#009A44;"></div>
                                </div>
                                <span class="small fw-semibold" style="width:3rem;">{{ $ligne['avancement'] }}%</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<div class="card card-stat p-3">
    <h6 class="fw-bold">Fiches PIP rattachées ({{ $programme->fichesPip->count() }})</h6>
    <table class="table table-sm mb-0">
        <thead><tr><th>Numéro</th><th>Nom</th><th>Projets associés</th></tr></thead>
        <tbody>
        @foreach($programme->fichesPip as $fiche)
            <tr>
                <td><a href="{{ route('fiches-pip.show', $fiche) }}">{{ $fiche->numero }}</a></td>
                <td>{{ $fiche->nom }}</td>
                <td>{{ $fiche->projets->pluck('intitule')->join(', ') ?: '—' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
