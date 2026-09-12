@extends('layouts.app')
@section('page-title', 'Réformes')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Réformes</h5>
    @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
    <a href="{{ route('reformes.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouvelle réforme</a>
    @endif
</div>
<form class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Rechercher (libellé)..."></div>
    <div class="col-md-3">
        <select name="statut" class="form-select form-select-sm">
            <option value="">Tous les statuts</option>
            <option value="demarree" @selected(request('statut')=='demarree')>Démarrée</option>
            <option value="en_cours" @selected(request('statut')=='en_cours')>En cours</option>
            <option value="achevee" @selected(request('statut')=='achevee')>Achevée</option>
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-sm btn-outline-secondary w-100">Filtrer</button></div>
</form>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Libellé</th><th>Structure</th><th>Axe</th><th>Statut</th><th>Période</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($reformes as $reforme)
                <tr>
                    <td><a href="{{ route('reformes.show', $reforme) }}" class="text-decoration-none">{{ $reforme->libelle }}</a></td>
                    <td>{{ $reforme->structure->libelle ?? '—' }}</td>
                    <td>{{ $reforme->axe->libelle ?? '—' }}</td>
                    <td><span class="badge bg-light text-dark border">{{ str_replace('_',' ',$reforme->statut) }}</span></td>
                    <td>{{ $reforme->annee_debut }} - {{ $reforme->annee_fin }}</td>
                    <td class="text-end">
                        <a href="{{ route('reformes.show', $reforme) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                        <a href="{{ route('reformes.edit', $reforme) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('reformes.destroy', $reforme) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette réforme ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucune réforme enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $reformes->links() }}</div>
@endsection
