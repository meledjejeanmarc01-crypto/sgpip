@extends('layouts.app')
@section('page-title', "État (acteur institutionnel)")
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">État — acteur institutionnel du financement public</h5>
    <a href="{{ route('etats.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouvelle fiche</a>
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Sigle</th><th>Libellé</th><th>Adresse</th><th>Financements</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($etats as $etat)
                <tr>
                    <td class="fw-semibold">{{ $etat->sigle }}</td>
                    <td>{{ $etat->libelle }}</td>
                    <td>{{ $etat->adresse ?? '—' }}</td>
                    <td>{{ $etat->financements_count }}</td>
                    <td class="text-end">
                        <a href="{{ route('etats.edit', $etat) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('etats.destroy', $etat) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucune fiche enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $etats->links() }}</div>
@endsection
