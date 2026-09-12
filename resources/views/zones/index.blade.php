@extends('layouts.app')
@section('page-title', 'Zones de localisation')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Zones de localisation</h5>
    <a href="{{ route('zones.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouvelle zone</a>
</div>
<p class="text-muted small">Hiérarchie : District &rarr; Région &rarr; Département &rarr; Sous-préfecture / Commune &rarr; Localité</p>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Type</th><th>Libellé</th><th>Zone parente</th><th>Projets</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($zones as $zone)
                <tr>
                    <td><span class="badge bg-light text-dark border">{{ str_replace('_',' ',$zone->type) }}</span></td>
                    <td><a href="{{ route('zones.show', $zone) }}" class="text-decoration-none">{{ $zone->libelle }}</a></td>
                    <td>{{ $zone->parent->libelle ?? '—' }}</td>
                    <td>{{ $zone->projets_count }}</td>
                    <td class="text-end">
                        <a href="{{ route('zones.edit', $zone) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('zones.destroy', $zone) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucune zone enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $zones->links() }}</div>
@endsection
