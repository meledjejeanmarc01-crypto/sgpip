@extends('layouts.app')
@section('page-title', 'Fiches PIP')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Fiches PIP</h5>
    <a href="{{ route('fiches-pip.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouvelle fiche</a>
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Numéro</th><th>Nom</th><th>Programme</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($fiches as $fiche)
                <tr>
                    <td class="fw-semibold">{{ $fiche->numero }}</td>
                    <td><a href="{{ route('fiches-pip.show', $fiche) }}" class="text-decoration-none">{{ $fiche->nom }}</a></td>
                    <td>{{ $fiche->programme->nom ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('fiches-pip.show', $fiche) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('fiches-pip.edit', $fiche) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('fiches-pip.destroy', $fiche) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Aucune fiche PIP enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $fiches->links() }}</div>
@endsection
