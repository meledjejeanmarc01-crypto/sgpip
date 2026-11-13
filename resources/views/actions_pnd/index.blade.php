@extends('layouts.app')
@section('page-title', 'Actions PND')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Actions du Plan National de Développement</h5>
    @if(auth()->user()->peutModifier('actions-pnd'))
    <a href="{{ route('actions-pnd.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouvelle action</a>
    @endif
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Libellé</th><th>Description</th><th>Projets rattachés</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($actions as $action)
                <tr>
                    <td>{{ $action->libelle }}</td>
                    <td class="text-muted small">{{ \Illuminate\Support\Str::limit($action->description, 80) }}</td>
                    <td>{{ $action->projets_count }}</td>
                    <td class="text-end">
                        @if(auth()->user()->peutModifier('actions-pnd'))
                        <a href="{{ route('actions-pnd.edit', $action) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('actions-pnd.destroy', $action) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Aucune action PND enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $actions->links() }}</div>
@endsection
