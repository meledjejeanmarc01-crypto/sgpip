@extends('layouts.app')
@section('page-title', 'Conventions de financement')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Conventions de financement</h5>
    <a href="{{ route('financements.index') }}" class="btn btn-sm btn-outline-secondary">Voir les financements</a>
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>N° d'accord signé</th><th>Projet</th><th>Bailleur</th><th>Type d'accord</th><th>Nature</th><th class="text-end">Montant</th><th>Signature</th><th>Limite de tirage</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse($conventions as $c)
                <tr>
                    <td>{{ $c->numero_accord_signe ?: '—' }}</td>
                    <td>@if($c->financement && $c->financement->projet)<a href="{{ route('projets.show', $c->financement->projet) }}" class="text-decoration-none">{{ $c->financement->projet->intitule }}</a>@else — @endif</td>
                    <td>{{ $c->financement->bailleur->nom ?? ($c->financement->source_libelle ?? '—') }}</td>
                    <td>{{ $c->type_accord ?: '—' }}</td>
                    <td>{{ $c->nature_financement ?: '—' }}</td>
                    <td class="text-end">{{ $c->montant !== null ? number_format($c->montant, 0, ',', ' ').' FCFA' : '—' }}</td>
                    <td>{{ optional($c->date_signature)->format('d/m/Y') ?? '—' }}</td>
                    <td>{{ optional($c->date_limite_tirage)->format('d/m/Y') ?? '—' }}</td>
                    <td class="text-end">
                        @if($c->financement && auth()->user()->peutModifierProjet($c->financement->projet))
                            <a href="{{ route('financements.edit', $c->financement) }}" class="btn btn-sm btn-outline-secondary" title="Modifier la convention"><i class="bi bi-pencil"></i></a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Aucune convention enregistrée. Une convention s'ajoute depuis la modification d'un financement.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $conventions->links() }}</div>
@endsection
