@extends('layouts.app')
@section('page-title', 'Dépenses')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Dépenses</h5>
    @if(auth()->user()->peutModifier('depenses'))
    <a href="{{ route('depenses.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouvelle dépense</a>
    @endif
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Référence</th><th>Libellé</th><th>Projet</th><th>Montant</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($depenses as $d)
                <tr>
                    <td>{{ $d->reference }}</td>
                    <td>{{ $d->libelle }}</td>
                    <td>{{ $d->projet->intitule ?? '—' }}</td>
                    <td>{{ number_format($d->montant,0,',',' ') }} FCFA</td>
                    <td>{{ $d->date->format('d/m/Y') }}</td>
                    <td class="text-end">
                        @if(auth()->user()->peutModifierProjet($d->projetAssocie()))
                        <a href="{{ route('depenses.edit', $d) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('depenses.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucune dépense enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $depenses->links() }}</div>
@endsection
