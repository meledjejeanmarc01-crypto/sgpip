@extends('layouts.app')
@section('page-title', 'Structures')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Structures</h5>
    @if(auth()->user()->peutModifier('structures'))
    <a href="{{ route('structures.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouvelle structure</a>
    @endif
</div>
<form class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Rechercher une structure..."></div>
    <div class="col-md-2"><button class="btn btn-sm btn-outline-secondary w-100">Filtrer</button></div>
</form>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Sigle</th><th>Libellé</th><th>Type</th><th>Téléphone</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($structures as $structure)
                <tr>
                    <td class="fw-semibold">{{ $structure->sigle }}</td>
                    <td><a href="{{ route('structures.show', $structure) }}" class="text-decoration-none">{{ $structure->libelle }}</a></td>
                    <td>{{ $structure->typeStructure->libelle ?? '—' }}</td>
                    <td>{{ $structure->telephone ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('structures.show', $structure) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        @if(auth()->user()->peutModifier('structures'))
                        <a href="{{ route('structures.edit', $structure) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('structures.destroy', $structure) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucune structure enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $structures->links() }}</div>
@endsection
