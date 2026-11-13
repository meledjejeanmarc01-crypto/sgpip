@extends('layouts.app')

@section('title', $secteur->libelle . ' - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <span class="badge text-bg-{{ $secteur->statut ? 'success' : 'secondary' }} mb-2">
                {{ $secteur->statut ? 'Actif' : 'Inactif' }}
            </span>
            <h2 class="fw-bold mb-1"><i class="bi bi-diagram-3"></i> {{ $secteur->libelle }}</h2>
        </div>
        <div class="d-flex gap-2">
            @if(auth()->user()->peutModifier('secteurs'))
            <a href="{{ route('secteurs.edit', $secteur) }}" class="btn btn-outline-warning"><i class="bi bi-pencil"></i> Modifier</a>
            @endif
            <a href="{{ route('secteurs.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Description</div>
        <div class="card-body">
            <p class="mb-0">{{ $secteur->description ?: 'Aucune description renseignée.' }}</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="bi bi-folder2-open"></i> Projets de ce secteur</span>
            <span class="badge text-bg-light">{{ $secteur->projets_count }}</span>
        </div>
        <div class="card-body p-0">
            @if($secteur->projets->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Référence</th><th>Intitulé</th><th>Statut</th></tr></thead>
                    <tbody>
                    @foreach($secteur->projets as $projet)
                        <tr>
                            <td><a href="{{ route('projets.show', $projet) }}" class="small">{{ $projet->reference }}</a></td>
                            <td>{{ $projet->intitule }}</td>
                            <td><span class="badge text-bg-light text-capitalize">{{ str_replace('_', ' ', $projet->statut) }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-3 mb-0">Aucun projet rattaché à ce secteur.</p>
            @endif
        </div>
    </div>

</div>
@endsection
