@extends('layouts.app')
@section('page-title', 'Bailleurs')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Bailleurs</h5>
    <a href="{{ route('bailleurs.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouveau bailleur</a>
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Sigle</th><th>Nom</th><th>Type</th><th>Contact</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($bailleurs as $bailleur)
                <tr>
                    <td class="fw-semibold">{{ $bailleur->sigle }}</td>
                    <td><a href="{{ route('bailleurs.show', $bailleur) }}" class="text-decoration-none">{{ $bailleur->nom }}</a></td>
                    <td>{{ $bailleur->typeBailleur->libelle ?? '—' }}</td>
                    <td>{{ $bailleur->contact ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('bailleurs.show', $bailleur) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('bailleurs.edit', $bailleur) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('bailleurs.destroy', $bailleur) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucun bailleur enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $bailleurs->links() }}</div>
@endsection
