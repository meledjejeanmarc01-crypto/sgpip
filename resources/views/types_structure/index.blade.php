@extends('layouts.app')
@section('page-title', 'Types de structure')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Types de structure</h5>
    <a href="{{ route('types-structure.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouveau type</a>
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Libellé</th><th>Structures rattachées</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($types as $type)
                <tr>
                    <td>{{ $type->libelle }}</td>
                    <td>{{ $type->structures_count }}</td>
                    <td class="text-end">
                        <a href="{{ route('types-structure.edit', $type) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('types-structure.destroy', $type) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">Aucun type de structure enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $types->links() }}</div>
@endsection
