@extends('layouts.app')
@section('page-title', 'Détail du programme')
@section('content')
<div class="card card-stat p-4 mb-3">
    <h5 class="fw-bold">{{ $programme->nom }} <span class="text-muted">({{ $programme->code }})</span></h5>
    <p class="text-muted mb-1">{{ $programme->libelle }}</p>
    <p class="text-muted mb-1">Structure pilote : {{ $programme->structure->libelle ?? '—' }}</p>
    <p class="text-muted mb-0">Période : {{ optional($programme->date_debut)->format('d/m/Y') }} - {{ optional($programme->date_fin)->format('d/m/Y') }}</p>
</div>
<div class="card card-stat p-3 mb-3">
    <h6 class="fw-bold mb-3">Axes du programme ({{ $programme->axes->count() }})</h6>
    @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
    <form method="POST" action="{{ route('axes.store', $programme) }}" class="row g-2 mb-3">
        @csrf
        <div class="col-md-8"><input type="text" name="libelle" class="form-control form-control-sm" placeholder="Libellé de l'axe" required></div>
        <div class="col-md-2"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">Ajouter</button></div>
    </form>
    @endif
    <ul class="list-group list-group-flush">
        @forelse($programme->axes as $axe)
        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
            <span>{{ $axe->libelle }}</span>
            @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
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
                                <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
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
