@extends('layouts.app')
@section('page-title', 'Acteurs')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Acteurs</h5>
    <a href="{{ route('acteurs.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouvel acteur</a>
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Libellé</th><th>Rôle</th><th>Groupe d'acteur</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($acteurs as $acteur)
                <tr>
                    <td>{{ $acteur->libelle }}</td>
                    <td>{{ $acteur->role }}</td>
                    <td>{{ $acteur->groupeActeur->libelle ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('acteurs.edit', $acteur) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('acteurs.destroy', $acteur) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Aucun acteur enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $acteurs->links() }}</div>
@endsection
