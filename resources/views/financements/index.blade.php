@extends('layouts.app')
@section('page-title', 'Financements')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Financements</h5>
    @if(auth()->user()->peutModifier('financements'))
    <a href="{{ route('financements.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouveau financement</a>
    @endif
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Référence</th><th>Projet</th><th>Source</th><th>Montant financé</th><th>Convention</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($financements as $f)
                <tr>
                    <td>{{ $f->reference }}</td>
                    <td><a href="{{ route('projets.show', $f->projet) }}">{{ $f->projet->intitule ?? '—' }}</a></td>
                    <td>{{ $f->source_libelle }}</td>
                    <td>{{ number_format($f->montant_engage,0,',',' ') }} FCFA</td>
                    <td>
                        @if($f->conventionFinancement)
                            <span class="badge bg-success">{{ $f->conventionFinancement->numero_accord_signe ?: 'Enregistrée' }}</span>
                        @elseif($f->numero_convention)
                            <span class="badge bg-success">{{ $f->numero_convention }}</span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>{{ $f->date->format('d/m/Y') }}</td>
                    <td class="text-end">
                        @if(auth()->user()->peutModifierProjet($f->projet))
                        <a href="{{ route('financements.edit', $f) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('financements.destroy', $f) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucun financement enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $financements->links() }}</div>
@endsection
