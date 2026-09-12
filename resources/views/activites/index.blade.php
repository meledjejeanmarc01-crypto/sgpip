@extends('layouts.app')

@section('title', 'Activités & tâches - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-list-check"></i> Activités & tâches</h2>
            <p class="text-muted mb-0">Vue d'ensemble des activités, tous projets confondus.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalActivite">
            <i class="bi bi-plus-lg"></i> Nouvelle activité
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
        <div class="col-auto">
            <select name="statut" class="form-select" onchange="this.form.submit()">
                <option value="">Tous statuts</option>
                @foreach(['planifiee'=>'Planifiée','en_cours'=>'En cours','terminee'=>'Terminée','suspendue'=>'Suspendue'] as $val => $label)
                    <option value="{{ $val }}" @selected(request('statut') == $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        @if(request('projet_id') || request('statut'))
            <div class="col-auto"><a href="{{ route('activites.index') }}" class="btn btn-outline-secondary">Réinitialiser</a></div>
        @endif
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @forelse ($activites as $activite)
                <div class="border-bottom p-3">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div>
                            <a href="{{ route('projets.show', $activite->projet) }}" class="text-decoration-none small text-muted">
                                {{ $activite->projet?->reference }} — {{ $activite->projet?->intitule }}
                            </a>
                            <div>
                                <strong>{{ $activite->intitule }}</strong>
                                <span class="badge text-bg-secondary text-capitalize ms-2">{{ str_replace('_', ' ', $activite->statut) }}</span>
                            </div>
                            <div class="small text-muted mt-1">
                                {{ $activite->date_debut?->format('d/m/Y') }} → {{ $activite->date_fin?->format('d/m/Y') }}
                                — Avancement : {{ $activite->taux_avancement }} %
                                — {{ $activite->taches->count() }} tâche(s)
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('projets.show', $activite->projet) }}" class="btn btn-sm btn-outline-primary" title="Voir le projet"><i class="bi bi-eye"></i></a>
                            <button
                                type="button"
                                class="btn btn-sm btn-outline-warning"
                                title="Modifier"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditActivite{{ $activite->id }}"
                            >
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('activites.destroy', $activite) }}" method="POST" onsubmit="return confirm('Supprimer cette activité et ses tâches ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>

                    @if($activite->taches->count())
                        <table class="table table-sm mt-3 mb-0">
                            <thead><tr><th>Tâche</th><th>Responsable</th><th>Statut</th><th>Avancement</th></tr></thead>
                            <tbody>
                            @foreach($activite->taches as $tache)
                                <tr>
                                    <td>{{ $tache->intitule }}</td>
                                    <td>{{ $tache->responsable ?? '—' }}</td>
                                    <td><span class="badge text-bg-light text-capitalize">{{ str_replace('_', ' ', $tache->statut) }}</span></td>
                                    <td>{{ $tache->taux_avancement }} %</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- MODAL MODIFIER ACTIVITE --}}
                <div class="modal fade" id="modalEditActivite{{ $activite->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('activites.update', $activite) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header"><h5 class="modal-title">Modifier l'activité</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body">
                                    <div class="mb-2"><label class="form-label">Intitulé</label><input type="text" name="intitule" class="form-control" value="{{ $activite->intitule }}" required></div>
                                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ $activite->description }}</textarea></div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6"><label class="form-label">Début</label><input type="date" name="date_debut" class="form-control" value="{{ $activite->date_debut?->format('Y-m-d') }}"></div>
                                        <div class="col-6"><label class="form-label">Fin</label><input type="date" name="date_fin" class="form-control" value="{{ $activite->date_fin?->format('Y-m-d') }}"></div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Statut</label>
                                        <select name="statut" class="form-select">
                                            @foreach(['planifiee'=>'Planifiée','en_cours'=>'En cours','terminee'=>'Terminée','suspendue'=>'Suspendue'] as $val => $label)
                                                <option value="{{ $val }}" @selected($activite->statut === $val)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2"><label class="form-label">Taux d'avancement (%)</label><input type="number" name="taux_avancement" min="0" max="100" step="0.01" value="{{ $activite->taux_avancement }}" class="form-control"></div>
                                </div>
                                <div class="modal-footer"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted p-4 mb-0">Aucune activité trouvée. Utilisez le bouton « Nouvelle activité » ci-dessus, ou ajoutez-en une depuis la fiche d'un projet.</p>
            @endforelse
        </div>
        <div class="card-footer bg-white">{{ $activites->links() }}</div>
    </div>
</div>

{{-- MODAL NOUVELLE ACTIVITE --}}
<div class="modal fade" id="modalActivite" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formActivite" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvelle activité</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Projet</label>
                        <select id="activiteProjetSelect" class="form-select" required>
                            <option value="">-- Sélectionner un projet --</option>
                            @foreach($projets as $p)
                                <option value="{{ $p->id }}">{{ $p->reference }} — {{ $p->intitule }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Intitulé</label><input type="text" name="intitule" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label">Début</label><input type="date" name="date_debut" class="form-control"></div>
                        <div class="col-6"><label class="form-label">Fin</label><input type="date" name="date_fin" class="form-control"></div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Statut</label>
                        <select name="statut" class="form-select">
                            <option value="planifiee">Planifiée</option>
                            <option value="en_cours">En cours</option>
                            <option value="terminee">Terminée</option>
                            <option value="suspendue">Suspendue</option>
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Taux d'avancement (%)</label><input type="number" name="taux_avancement" min="0" max="100" step="0.01" value="0" class="form-control"></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary" id="btnActiviteSubmit" disabled>Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('activiteProjetSelect').addEventListener('change', function () {
        const form = document.getElementById('formActivite');
        const btn = document.getElementById('btnActiviteSubmit');
        if (this.value) {
            form.action = '/projets/' + this.value + '/activites';
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    });
</script>
@endpush
@endsection
