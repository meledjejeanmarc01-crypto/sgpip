@extends('layouts.app')
@section('page-title', "Zones d'exécution")
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Zones d'exécution</h5>
    @if(auth()->user()->peutModifier('zones'))
    <a href="{{ route('zones.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouvelle zone</a>
    @endif
</div>
<p class="text-muted small">
    Une zone d'exécution est rattachée à une localisation de n'importe quel niveau (District, Région, Département, Commune, Sous-préfecture ou Village).
    La hiérarchie géographique se gère depuis la page <a href="{{ route('localisation.index') }}">Localisation géographique</a>.
</p>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Rechercher par libellé">
    </div>
    <div class="col-md-3">
        <select name="niveau_id" class="form-select form-select-sm">
            <option value="">Tous les niveaux</option>
            @foreach($niveaux as $n)
                <option value="{{ $n->id }}" @selected(request('niveau_id') == $n->id)>{{ $n->libelle }}</option>
            @endforeach
            <option value="hors_ci" @selected(request('niveau_id') === 'hors_ci')>Hors Côte d'Ivoire</option>
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-sm btn-outline-primary">Filtrer</button>
        <a href="{{ route('zones.index') }}" class="btn btn-sm btn-outline-secondary">Réinitialiser</a>
    </div>
</form>

<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Libellé</th><th>Niveau</th><th>Rattachement</th><th>Pays</th><th>Projets</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($zones as $zone)
                <tr>
                    <td><a href="{{ route('zones.show', $zone) }}" class="text-decoration-none">{{ $zone->libelle }}</a></td>
                    <td>
                        @if($zone->localisation)
                            <span class="badge bg-secondary">{{ $zone->localisation->niveau->libelle }}</span>
                        @else
                            <span class="badge bg-dark">Hors CI</span>
                        @endif
                    </td>
                    <td>{{ $zone->localisation?->parent_immediat?->libelle ?? '—' }}</td>
                    <td>{{ $zone->paysEtranger?->libelle ?? $zone->pays ?? '—' }}</td>
                    <td>{{ $zone->projets_count }}</td>
                    <td class="text-end">
                        @if(auth()->user()->peutModifier('zones'))
                        <a href="{{ route('zones.edit', $zone) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('zones.destroy', $zone) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucune zone enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $zones->links() }}</div>
@endsection
