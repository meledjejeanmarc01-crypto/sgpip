@extends('layouts.app')

@section('title', 'Indicateurs - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-graph-up"></i> Indicateurs de suivi</h2>
            <p class="text-muted mb-0">Vue d'ensemble des indicateurs, tous projets confondus.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalIndicateur">
            <i class="bi bi-plus-lg"></i> Nouvel indicateur
        </button>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <select name="projet_id" class="form-select" onchange="this.form.submit()">
                <option value="">Tous les projets</option>
                @foreach($projets as $p)
                    <option value="{{ $p->id }}" @selected(request('projet_id') == $p->id)>{{ $p->reference }} — {{ $p->intitule }}</option>
                @endforeach
            </select>
        </div>
        @if(request('projet_id'))
            <div class="col-auto"><a href="{{ route('indicateurs.index') }}" class="btn btn-outline-secondary">Réinitialiser</a></div>
        @endif
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($indicateurs->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Projet</th><th>Nom</th><th>Unité</th><th>Cible</th><th>Réalisé</th><th>Date mesure</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @foreach($indicateurs as $ind)
                        <tr>
                            <td><a href="{{ route('projets.show', $ind->projet) }}" class="small">{{ $ind->projet?->reference }}</a></td>
                            <td>{{ $ind->nom }}</td>
                            <td>{{ $ind->unite ?? '—' }}</td>
                            <td>{{ $ind->valeur_cible ?? '—' }}</td>
                            <td>{{ $ind->valeur_realisee ?? '—' }}</td>
                            <td>{{ $ind->date_mesure?->format('d/m/Y') ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('projets.show', $ind->projet) }}" class="btn btn-sm btn-outline-primary" title="Voir le projet"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-warning" title="Modifier" data-bs-toggle="modal" data-bs-target="#modalEditIndicateur{{ $ind->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('indicateurs.destroy', $ind) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL MODIFIER INDICATEUR --}}
                        <tr class="d-none">
                            <td colspan="7">
                                <div class="modal fade" id="modalEditIndicateur{{ $ind->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('indicateurs.update', $ind) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-header"><h5 class="modal-title">Modifier l'indicateur</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                                <div class="modal-body">
                                                    <div class="mb-2"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" value="{{ $ind->nom }}" required></div>
                                                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ $ind->description }}</textarea></div>
                                                    <div class="mb-2"><label class="form-label">Unité</label><input type="text" name="unite" class="form-control" value="{{ $ind->unite }}"></div>
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-6"><label class="form-label">Valeur cible</label><input type="number" step="0.01" name="valeur_cible" class="form-control" value="{{ $ind->valeur_cible }}"></div>
                                                        <div class="col-6"><label class="form-label">Valeur réalisée</label><input type="number" step="0.01" name="valeur_realisee" class="form-control" value="{{ $ind->valeur_realisee }}"></div>
                                                    </div>
                                                    <div class="mb-2"><label class="form-label">Date de mesure</label><input type="date" name="date_mesure" class="form-control" value="{{ $ind->date_mesure?->format('Y-m-d') }}"></div>
                                                    <div class="mb-2"><label class="form-label">Observation</label><textarea name="observation" class="form-control" rows="2">{{ $ind->observation }}</textarea></div>
                                                </div>
                                                <div class="modal-footer"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-4 mb-0">Aucun indicateur trouvé. Utilisez le bouton « Nouvel indicateur » ci-dessus, ou ajoutez-en un depuis la fiche d'un projet.</p>
            @endif
        </div>
        <div class="card-footer bg-white">{{ $indicateurs->links() }}</div>
    </div>
</div>

{{-- MODAL NOUVEL INDICATEUR --}}
<div class="modal fade" id="modalIndicateur" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formIndicateur" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvel indicateur</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Projet</label>
                        <select id="indicateurProjetSelect" class="form-select" required>
                            <option value="">-- Sélectionner un projet --</option>
                            @foreach($projets as $p)
                                <option value="{{ $p->id }}">{{ $p->reference }} — {{ $p->intitule }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                    <div class="mb-2"><label class="form-label">Unité</label><input type="text" name="unite" class="form-control" placeholder="Ex : km, %, nombre..."></div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label">Valeur cible</label><input type="number" step="0.01" name="valeur_cible" class="form-control"></div>
                        <div class="col-6"><label class="form-label">Valeur réalisée</label><input type="number" step="0.01" name="valeur_realisee" class="form-control"></div>
                    </div>
                    <div class="mb-2"><label class="form-label">Date de mesure</label><input type="date" name="date_mesure" class="form-control"></div>
                    <div class="mb-2"><label class="form-label">Observation</label><textarea name="observation" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary" id="btnIndicateurSubmit" disabled>Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('indicateurProjetSelect').addEventListener('change', function () {
        const form = document.getElementById('formIndicateur');
        const btn = document.getElementById('btnIndicateurSubmit');
        if (this.value) {
            form.action = '/projets/' + this.value + '/indicateurs';
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    });
</script>
@endpush
@endsection
