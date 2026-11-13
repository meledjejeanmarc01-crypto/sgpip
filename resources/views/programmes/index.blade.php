@extends('layouts.app')
@section('page-title', 'Programmes')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Programmes</h5>
    @if(auth()->user()->peutModifier('programmes'))
    <a href="{{ route('programmes.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouveau programme</a>
    @endif
</div>
<form class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Rechercher (nom, code)..."></div>
    <div class="col-md-2"><button class="btn btn-sm btn-outline-secondary w-100">Filtrer</button></div>
</form>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Code</th><th>Nom</th><th>Structure pilote</th><th>Période</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($programmes as $programme)
                <tr>
                    <td class="fw-semibold">{{ $programme->code }}</td>
                    <td><a href="{{ route('programmes.show', $programme) }}" class="text-decoration-none">{{ $programme->nom }}</a></td>
                    <td>{{ $programme->structure->libelle ?? '—' }}</td>
                    <td>{{ optional($programme->date_debut)->format('d/m/Y') }} - {{ optional($programme->date_fin)->format('d/m/Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('programmes.show', $programme) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        @if(auth()->user()->peutModifier('programmes'))
                        <a href="{{ route('programmes.edit', $programme) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('programmes.destroy', $programme) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucun programme enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $programmes->links() }}</div>
@endsection
