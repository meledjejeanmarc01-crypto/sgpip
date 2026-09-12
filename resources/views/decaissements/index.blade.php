@extends('layouts.app')
@section('page-title', 'Décaissements')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Décaissements</h5>
    @if(auth()->user()->hasRole(['administrateur','responsable_financier']))
    <a href="{{ route('decaissements.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouveau décaissement</a>
    @endif
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Référence</th><th>Bailleur</th><th>Financement / Projet</th><th>Montant</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($decaissements as $d)
                <tr>
                    <td>{{ $d->reference }}</td>
                    <td>{{ $d->bailleur->nom ?? '—' }}</td>
                    <td>{{ $d->financement->reference ?? '—' }} @if($d->financement?->projet) <span class="text-muted">({{ $d->financement->projet->intitule }})</span> @endif</td>
                    <td>{{ number_format($d->montant,0,',',' ') }} FCFA</td>
                    <td>{{ $d->date->format('d/m/Y') }}</td>
                    <td class="text-end">
                        @if(auth()->user()->hasRole(['administrateur','responsable_financier']))
                        <a href="{{ route('decaissements.edit', $d) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('decaissements.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucun décaissement enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $decaissements->links() }}</div>
@endsection
