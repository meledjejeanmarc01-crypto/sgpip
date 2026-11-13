@extends('layouts.app')
@section('page-title', 'Rapports')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Rapports de suivi</h5>
    @if(auth()->user()->peutModifier('rapports'))
    <a href="{{ route('rapports.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouveau rapport</a>
    @endif
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Titre</th><th>Type</th><th>Projet</th><th>Auteur</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($rapports as $r)
                <tr>
                    <td><a href="{{ route('rapports.show', $r) }}" class="text-decoration-none">{{ $r->titre }}</a></td>
                    <td><span class="badge bg-light text-dark border">{{ str_replace('_',' ',$r->type) }}</span></td>
                    <td>{{ $r->projet->intitule ?? '—' }}</td>
                    <td>{{ $r->utilisateur->prenom ?? '' }} {{ $r->utilisateur->nom ?? '' }}</td>
                    <td>{{ $r->date->format('d/m/Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('rapports.show', [$r, 'imprimer' => 1]) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Imprimer le rapport (document mis en page)"><i class="bi bi-printer"></i></a>
                        @if($r->fichier)<a href="{{ route('rapports.download', $r) }}" class="btn btn-sm btn-outline-secondary" title="Télécharger le fichier joint tel quel"><i class="bi bi-paperclip"></i></a>@endif
                        @if(auth()->user()->peutModifierProjet($r->projet))
                        <a href="{{ route('rapports.edit', $r) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('rapports.destroy', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucun rapport enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $rapports->links() }}</div>
@endsection
