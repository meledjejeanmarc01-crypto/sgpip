@extends('layouts.app')
@section('page-title', 'Secteurs')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Secteurs</h5>
    @if(auth()->user()->peutModifier('secteurs'))
    <a href="{{ route('secteurs.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouveau secteur</a>
    @endif
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Libellé</th><th>Projets rattachés</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($secteurs as $secteur)
                <tr>
                    <td>{{ $secteur->libelle }}</td>
                    <td>{{ $secteur->projets_count }}</td>
                    <td class="text-end">
                        @if(auth()->user()->peutModifier('secteurs'))
                        <a href="{{ route('secteurs.edit', $secteur) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('secteurs.destroy', $secteur) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">Aucun secteur enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $secteurs->links() }}</div>
@endsection
