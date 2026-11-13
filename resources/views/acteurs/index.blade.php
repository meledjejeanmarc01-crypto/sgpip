@extends('layouts.app')
@section('page-title', 'Acteurs')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Acteurs</h5>
    @if(auth()->user()->peutModifier('acteurs'))
    <a href="{{ route('acteurs.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouvel acteur</a>
    @endif
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Libellé</th><th>Fonction</th><th>Groupe d'acteur</th><th>Partie prenante</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($acteurs as $acteur)
                <tr>
                    <td>{{ $acteur->libelle }}</td>
                    <td>{{ $acteur->role }}</td>
                    <td>{{ $acteur->groupeActeur->libelle ?? '—' }}</td>
                    <td>{{ $acteur->partiePrenante->libelle ?? '—' }}</td>
                    <td class="text-end">
                        @if(auth()->user()->peutModifier('acteurs'))
                        <a href="{{ route('acteurs.edit', $acteur) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('acteurs.destroy', $acteur) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucun acteur enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $acteurs->links() }}</div>
@endsection
