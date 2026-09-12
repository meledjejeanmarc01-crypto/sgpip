@extends('layouts.app')
@section('page-title', 'Détail du projet')
@section('content')

<div class="card card-stat p-4 mb-3">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <span class="text-muted small">{{ $projet->reference }}</span>
            @if($projet->code_pip)<span class="text-muted small"> · Code PIP : {{ $projet->code_pip }}</span>@endif
            <h5 class="fw-bold mb-1">{{ $projet->intitule }}</h5>
            <span class="badge badge-statut-{{ $projet->statut }}">{{ str_replace('_',' ',$projet->statut) }}</span>
            <span class="badge bg-light text-dark border">{{ $projet->type_projet == 'routine' ? 'Routine' : "Projet d'investissement" }}</span>
        </div>
        @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
        <div>
            <a href="{{ route('projets.edit', $projet) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i> Modifier</a>
            <form action="{{ route('projets.destroy', $projet) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression du projet ?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Supprimer</button>
            </form>
        </div>
        @endif
    </div>
    <hr>
    <div class="row small">
        <div class="col-md-3"><strong>Structure :</strong> {{ $projet->structure->libelle ?? '—' }}</div>
        <div class="col-md-3"><strong>Secteur :</strong> {{ $projet->secteur->libelle ?? '—' }}</div>
        <div class="col-md-3"><strong>Zone :</strong> {{ $projet->zoneLocalisation->libelle ?? '—' }}</div>
        <div class="col-md-3"><strong>Coût estimatif :</strong> {{ number_format($projet->cout_estimatif,0,',',' ') }} FCFA</div>
    </div>
    <div class="row small mt-2">
        <div class="col-md-3"><strong>Début :</strong> {{ optional($projet->date_debut)->format('d/m/Y') ?? '—' }}</div>
        <div class="col-md-3"><strong>Fin :</strong> {{ optional($projet->date_fin)->format('d/m/Y') ?? '—' }}</div>
        <div class="col-md-3"><strong>Fiches PIP :</strong> {{ $projet->fichesPip->pluck('numero')->join(', ') ?: '—' }}</div>
        <div class="col-md-3"><strong>Axe :</strong> {{ $projet->axe->libelle ?? '—' }}</div>
    </div>
    <div class="row small mt-2">
        <div class="col-md-3"><strong>Maître d'ouvrage :</strong> {{ $projet->maitre_ouvrage ?? '—' }}</div>
        <div class="col-md-3"><strong>Maître d'ouvrage délégué :</strong> {{ $projet->maitre_ouvrage_delegue ?? '—' }}</div>
        <div class="col-md-3"><strong>Maître d'œuvre :</strong> {{ $projet->maitre_oeuvre ?? '—' }}</div>
        <div class="col-md-3"><strong>Durée prévue :</strong> {{ $projet->duree_prevue ?? '—' }}</div>
    </div>
    <div class="row small mt-2">
        <div class="col-md-3"><strong>Milieu d'exécution :</strong> {{ $projet->milieu_execution ? str_replace('_',' ',$projet->milieu_execution) : '—' }}</div>
        <div class="col-md-3"><strong>ODD concerné :</strong> {{ $projet->odd_concerne ?? '—' }}</div>
        <div class="col-md-3"><strong>Action PND :</strong> {{ $projet->action_pnd ?? '—' }}</div>
        <div class="col-md-3"><strong>Programme budgétaire :</strong> {{ $projet->programme_budgetaire ?? '—' }}</div>
    </div>
    <div class="row small mt-2">
        <div class="col-md-4"><strong>Domaine d'impact socio-économique :</strong> {{ $projet->domaine_impact_socio_eco ?? '—' }}</div>
        <div class="col-md-4"><strong>Code PJGouv :</strong> {{ $projet->code_pjgouv ?? '—' }}</div>
        <div class="col-md-4"><strong>Code PSGouv :</strong> {{ $projet->code_psgouv ?? '—' }}</div>
    </div>
    <div class="row small mt-2 text-center">
        <div class="col-md-3"><div class="text-muted">Cible T1</div><div class="fw-semibold">{{ $projet->cible_trimestre_1 ?: '—' }}</div></div>
        <div class="col-md-3"><div class="text-muted">Cible T2</div><div class="fw-semibold">{{ $projet->cible_trimestre_2 ?: '—' }}</div></div>
        <div class="col-md-3"><div class="text-muted">Cible T3</div><div class="fw-semibold">{{ $projet->cible_trimestre_3 ?: '—' }}</div></div>
        <div class="col-md-3"><div class="text-muted">Cible T4</div><div class="fw-semibold">{{ $projet->cible_trimestre_4 ?: '—' }}</div></div>
    </div>
    <div class="mt-3">
        <div class="d-flex justify-content-between small mb-1"><span>Avancement physique</span><span>{{ $projet->avancement_physique }}%</span></div>
        <div class="progress" style="height:8px;"><div class="progress-bar bg-success" style="width: {{ $projet->avancement_physique }}%"></div></div>
    </div>
    @if($projet->contexte)<p class="mt-3 small mb-1"><strong>Contexte :</strong> {{ $projet->contexte }}</p>@endif
    @if($projet->objectif)<p class="small mb-0"><strong>Objectif :</strong> {{ $projet->objectif }}</p>@endif
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card card-stat p-3">
            <div class="text-muted small">Montant engagé</div>
            <div class="fw-bold">{{ number_format($projet->montant_engage,0,',',' ') }} FCFA</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat p-3">
            <div class="text-muted small">Montant décaissé</div>
            <div class="fw-bold">{{ number_format($projet->montant_decaisse,0,',',' ') }} FCFA</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat p-3">
            <div class="text-muted small">Montant dépensé</div>
            <div class="fw-bold">{{ number_format($projet->montant_depense,0,',',' ') }} FCFA</div>
        </div>
    </div>
</div>

<ul class="nav nav-tabs mb-3 flex-nowrap overflow-auto" role="tablist">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#activites">Activités & tâches</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#composantes">Composantes</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#objectifs">Objectifs spécifiques</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#financier">Financements</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#marches">Marchés</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#charges">Charges récurrentes</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#risques">Risques</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#parties">Parties prenantes</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#cibles">Cibles</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#etudes">Études</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#rapports">Rapports</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pieces">Pièces justificatives</button></li>
</ul>

<div class="tab-content">
    {{-- Activités / tâches / indicateurs --}}
    <div class="tab-pane fade show active" id="activites">
        @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
        <div class="card card-stat p-3 mb-3">
            <h6 class="fw-bold mb-3">Ajouter une activité</h6>
            <form method="POST" action="{{ route('activites.store', $projet) }}" class="row g-2">
                @csrf
                <div class="col-md-4"><input type="text" name="intitule" class="form-control form-control-sm" placeholder="Intitulé" required></div>
                <div class="col-md-2"><input type="date" name="date_debut" class="form-control form-control-sm"></div>
                <div class="col-md-2"><input type="date" name="date_fin" class="form-control form-control-sm"></div>
                <div class="col-md-2"><input type="number" min="0" max="100" name="taux_avancement" class="form-control form-control-sm" placeholder="% avancement" value="0" required></div>
                <div class="col-md-2"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">Ajouter</button></div>
            </form>
        </div>
        @endif

        @forelse($projet->activites as $activite)
        <div class="card card-stat p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-1">{{ $activite->intitule }}</h6>
                @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                <div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editActivite{{ $activite->id }}" title="Voir / Modifier"><i class="bi bi-pencil"></i> Modifier</button>
                    <form action="{{ route('activites.destroy', $activite) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette activité (ainsi que ses tâches et indicateurs) ?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
                @endif
            </div>
            <div class="small text-muted mb-2">{{ optional($activite->date_debut)->format('d/m/Y') }} — {{ optional($activite->date_fin)->format('d/m/Y') }} · Avancement : {{ $activite->taux_avancement }}%</div>
            <div class="progress mb-3" style="height:6px;"><div class="progress-bar" style="background:#009A44; width: {{ $activite->taux_avancement }}%"></div></div>

            {{-- Modale Voir / Modifier l'activité --}}
            @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
            <div class="modal fade" id="editActivite{{ $activite->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('activites.update', $activite) }}">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h6 class="modal-title fw-bold">Modifier l'activité</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Intitulé</label>
                                    <input type="text" name="intitule" value="{{ $activite->intitule }}" class="form-control" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Date début</label>
                                        <input type="date" name="date_debut" value="{{ optional($activite->date_debut)->format('Y-m-d') }}" class="form-control">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Date fin</label>
                                        <input type="date" name="date_fin" value="{{ optional($activite->date_fin)->format('Y-m-d') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">Taux d'avancement (%)</label>
                                    <input type="number" min="0" max="100" name="taux_avancement" value="{{ $activite->taux_avancement }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="small fw-semibold mb-1">Tâches</div>
                    <ul class="list-unstyled small">
                        @forelse($activite->taches as $tache)
                        <li class="border-bottom py-1 d-flex justify-content-between align-items-center">
                            <span>{{ $tache->intitule }} @if($tache->depense)<span class="text-muted">({{ number_format($tache->depense->montant,0,',',' ') }} FCFA)</span>@endif</span>
                            @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                            <span class="text-nowrap">
                                <button type="button" class="btn btn-sm btn-link p-0 me-2" data-bs-toggle="modal" data-bs-target="#editTache{{ $tache->id }}" title="Voir / Modifier"><i class="bi bi-pencil"></i></button>
                                <form action="{{ route('taches.destroy', $tache) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette tâche ?');">
                                    @csrf @method('DELETE')<button class="btn btn-sm btn-link text-danger p-0" title="Supprimer"><i class="bi bi-trash"></i></button>
                                </form>
                            </span>
                            @endif

                            {{-- Modale Voir / Modifier la tâche --}}
                            <div class="modal fade" id="editTache{{ $tache->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('taches.update', $tache) }}">
                                            @csrf @method('PUT')
                                            <div class="modal-header">
                                                <h6 class="modal-title fw-bold">Modifier la tâche</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Intitulé</label>
                                                    <input type="text" name="intitule" value="{{ $tache->intitule }}" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="description" class="form-control" rows="2">{{ $tache->description }}</textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Date début</label>
                                                        <input type="date" name="date_debut" value="{{ optional($tache->date_debut)->format('Y-m-d') }}" class="form-control">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Date fin</label>
                                                        <input type="date" name="date_fin" value="{{ optional($tache->date_fin)->format('Y-m-d') }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label">Dépense rattachée (optionnel)</label>
                                                    <select name="depense_id" class="form-select">
                                                        <option value="">-- Aucune --</option>
                                                        @foreach($projet->depenses as $dep)
                                                            <option value="{{ $dep->id }}" @selected($tache->depense_id == $dep->id)>{{ $dep->reference }} — {{ number_format($dep->montant,0,',',' ') }} FCFA</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="text-muted">Aucune tâche.</li>
                        @endforelse
                    </ul>
                    @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                    <form method="POST" action="{{ route('taches.store', $activite) }}" class="d-flex gap-1 mt-1">
                        @csrf
                        <input type="text" name="intitule" class="form-control form-control-sm" placeholder="Nouvelle tâche" required>
                        <button class="btn btn-sm btn-outline-secondary">+</button>
                    </form>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="small fw-semibold mb-1">Indicateurs</div>
                    <ul class="list-unstyled small">
                        @forelse($activite->indicateurs as $indicateur)
                        <li class="border-bottom py-1 d-flex justify-content-between align-items-center">
                            <span>{{ $indicateur->nom }} : {{ $indicateur->valeur_realisee ?? 0 }} / {{ $indicateur->valeur_cible ?? '—' }} {{ $indicateur->unite }}</span>
                            @if(auth()->user()->hasRole(['administrateur','responsable_suivi_evaluation']))
                            <span class="text-nowrap">
                                <button type="button" class="btn btn-sm btn-link p-0 me-2" data-bs-toggle="modal" data-bs-target="#editIndicateur{{ $indicateur->id }}" title="Voir / Modifier"><i class="bi bi-pencil"></i></button>
                                <form action="{{ route('indicateurs.destroy', $indicateur) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?');">
                                    @csrf @method('DELETE')<button class="btn btn-sm btn-link text-danger p-0" title="Supprimer"><i class="bi bi-trash"></i></button>
                                </form>
                            </span>
                            @endif

                            {{-- Modale Voir / Modifier l'indicateur --}}
                            <div class="modal fade" id="editIndicateur{{ $indicateur->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('indicateurs.update', $indicateur) }}">
                                            @csrf @method('PUT')
                                            <div class="modal-header">
                                                <h6 class="modal-title fw-bold">Modifier l'indicateur</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nom de l'indicateur</label>
                                                    <input type="text" name="nom" value="{{ $indicateur->nom }}" class="form-control" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 mb-3">
                                                        <label class="form-label">Unité</label>
                                                        <input type="text" name="unite" value="{{ $indicateur->unite }}" class="form-control">
                                                    </div>
                                                    <div class="col-4 mb-3">
                                                        <label class="form-label">Valeur cible</label>
                                                        <input type="number" step="0.01" name="valeur_cible" value="{{ $indicateur->valeur_cible }}" class="form-control">
                                                    </div>
                                                    <div class="col-4 mb-3">
                                                        <label class="form-label">Valeur réalisée</label>
                                                        <input type="number" step="0.01" name="valeur_realisee" value="{{ $indicateur->valeur_realisee }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label">Date de mesure</label>
                                                    <input type="date" name="date_mesure" value="{{ optional($indicateur->date_mesure)->format('Y-m-d') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="text-muted">Aucun indicateur.</li>
                        @endforelse
                    </ul>
                    @if(auth()->user()->hasRole(['administrateur','responsable_suivi_evaluation']))
                    <form method="POST" action="{{ route('indicateurs.store', $activite) }}" class="row g-1 mt-1">
                        @csrf
                        <div class="col-5"><input type="text" name="nom" class="form-control form-control-sm" placeholder="Indicateur" required></div>
                        <div class="col-3"><input type="number" step="0.01" name="valeur_cible" class="form-control form-control-sm" placeholder="Cible"></div>
                        <div class="col-3"><input type="number" step="0.01" name="valeur_realisee" class="form-control form-control-sm" placeholder="Réalisé"></div>
                        <div class="col-1"><button class="btn btn-sm btn-outline-secondary w-100">+</button></div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">Aucune activité enregistrée pour ce projet.</p>
        @endforelse
    </div>

    {{-- Composantes --}}
    <div class="tab-pane fade" id="composantes">
        <div class="card card-stat p-3">
            @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
            <form method="POST" action="{{ route('composantes.store', $projet) }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-8"><input type="text" name="libelle" class="form-control form-control-sm" placeholder="Libellé de la composante" required></div>
                <div class="col-md-3"><input type="number" step="0.01" min="0" name="budget_previsionnel" class="form-control form-control-sm" placeholder="Budget prévisionnel"></div>
                <div class="col-md-1"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">+</button></div>
            </form>
            @endif
            <table class="table table-sm mb-0">
                <thead><tr><th>Libellé</th><th>Budget prévisionnel</th><th></th></tr></thead>
                <tbody>
                @forelse($projet->composantes as $composante)
                <tr>
                    <td>{{ $composante->libelle }}</td>
                    <td>{{ number_format($composante->budget_previsionnel,0,',',' ') }} FCFA</td>
                    <td class="text-end">
                        @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editComposante{{ $composante->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('composantes.destroy', $composante) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette composante ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <div class="modal fade" id="editComposante{{ $composante->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <form method="POST" action="{{ route('composantes.update', $composante) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h6 class="modal-title fw-bold">Modifier la composante</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-3"><label class="form-label">Libellé</label><input type="text" name="libelle" value="{{ $composante->libelle }}" class="form-control" required></div>
                                        <div class="mb-1"><label class="form-label">Budget prévisionnel</label><input type="number" step="0.01" name="budget_previsionnel" value="{{ $composante->budget_previsionnel }}" class="form-control"></div>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button><button class="btn text-white" style="background:#FF8200;">Enregistrer</button></div>
                                </form>
                            </div></div>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-muted text-center">Aucune composante enregistrée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Risques --}}
    <div class="tab-pane fade" id="risques">
        <div class="card card-stat p-3">
            @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
            <form method="POST" action="{{ route('risques.store', $projet) }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-3"><input type="text" name="libelle" class="form-control form-control-sm" placeholder="Libellé du risque" required></div>
                <div class="col-md-3"><input type="text" name="consequence" class="form-control form-control-sm" placeholder="Conséquence"></div>
                <div class="col-md-2">
                    <select name="probabilite" class="form-select form-select-sm" required>
                        <option value="">Probabilité</option>
                        <option value="faible">Faible</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="forte">Forte</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="criticite" class="form-select form-select-sm" required>
                        <option value="">Criticité</option>
                        <option value="faible">Faible</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="elevee">Élevée</option>
                    </select>
                </div>
                <div class="col-md-2"><input type="text" name="type_strategie" class="form-control form-control-sm" placeholder="Stratégie"></div>
                <div class="col-md-12"><input type="text" name="mesure_mitigation" class="form-control form-control-sm" placeholder="Mesure de mitigation"></div>
                <div class="col-md-2"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">Ajouter</button></div>
            </form>
            @endif
            <table class="table table-sm mb-0">
                <thead><tr><th>Libellé</th><th>Conséquence</th><th>Probabilité</th><th>Criticité</th><th>Mitigation</th><th></th></tr></thead>
                <tbody>
                @forelse($projet->risques as $risque)
                <tr>
                    <td>{{ $risque->libelle }}</td>
                    <td>{{ $risque->consequence }}</td>
                    <td><span class="badge bg-light text-dark border">{{ ucfirst($risque->probabilite) }}</span></td>
                    <td><span class="badge bg-light text-dark border">{{ ucfirst($risque->criticite) }}</span></td>
                    <td>{{ $risque->mesure_mitigation }}</td>
                    <td class="text-end">
                        @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editRisque{{ $risque->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('risques.destroy', $risque) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce risque ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <div class="modal fade" id="editRisque{{ $risque->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <form method="POST" action="{{ route('risques.update', $risque) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h6 class="modal-title fw-bold">Modifier le risque</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-2"><label class="form-label">Libellé</label><input type="text" name="libelle" value="{{ $risque->libelle }}" class="form-control" required></div>
                                        <div class="mb-2"><label class="form-label">Conséquence</label><input type="text" name="consequence" value="{{ $risque->consequence }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Probabilité</label>
                                            <select name="probabilite" class="form-select" required>
                                                <option value="faible" @selected($risque->probabilite=='faible')>Faible</option>
                                                <option value="moyenne" @selected($risque->probabilite=='moyenne')>Moyenne</option>
                                                <option value="forte" @selected($risque->probabilite=='forte')>Forte</option>
                                            </select>
                                        </div>
                                        <div class="mb-2"><label class="form-label">Criticité</label>
                                            <select name="criticite" class="form-select" required>
                                                <option value="faible" @selected($risque->criticite=='faible')>Faible</option>
                                                <option value="moyenne" @selected($risque->criticite=='moyenne')>Moyenne</option>
                                                <option value="elevee" @selected($risque->criticite=='elevee')>Élevée</option>
                                            </select>
                                        </div>
                                        <div class="mb-2"><label class="form-label">Stratégie</label><input type="text" name="type_strategie" value="{{ $risque->type_strategie }}" class="form-control"></div>
                                        <div class="mb-1"><label class="form-label">Mesure de mitigation</label><input type="text" name="mesure_mitigation" value="{{ $risque->mesure_mitigation }}" class="form-control"></div>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button><button class="btn text-white" style="background:#FF8200;">Enregistrer</button></div>
                                </form>
                            </div></div>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-muted text-center">Aucun risque enregistré.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Parties prenantes --}}
    <div class="tab-pane fade" id="parties">
        <div class="card card-stat p-3">
            @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
            <form method="POST" action="{{ route('parties-prenantes.store', $projet) }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-6"><input type="text" name="groupe_acteurs" class="form-control form-control-sm" placeholder="Groupe d'acteurs" required></div>
                <div class="col-md-4"><input type="text" name="role" class="form-control form-control-sm" placeholder="Rôle"></div>
                <div class="col-md-2"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">Ajouter</button></div>
            </form>
            @endif
            <table class="table table-sm mb-0">
                <thead><tr><th>Groupe d'acteurs</th><th>Rôle</th><th></th></tr></thead>
                <tbody>
                @forelse($projet->partiesPrenantes as $partie)
                <tr>
                    <td>{{ $partie->groupe_acteurs }}</td>
                    <td>{{ $partie->role }}</td>
                    <td class="text-end">
                        @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editPartie{{ $partie->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('parties-prenantes.destroy', $partie) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette partie prenante ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <div class="modal fade" id="editPartie{{ $partie->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <form method="POST" action="{{ route('parties-prenantes.update', $partie) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h6 class="modal-title fw-bold">Modifier la partie prenante</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-2"><label class="form-label">Groupe d'acteurs</label><input type="text" name="groupe_acteurs" value="{{ $partie->groupe_acteurs }}" class="form-control" required></div>
                                        <div class="mb-1"><label class="form-label">Rôle</label><input type="text" name="role" value="{{ $partie->role }}" class="form-control"></div>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button><button class="btn text-white" style="background:#FF8200;">Enregistrer</button></div>
                                </form>
                            </div></div>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-muted text-center">Aucune partie prenante enregistrée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Cibles (bénéficiaires) --}}
    <div class="tab-pane fade" id="cibles">
        <div class="card card-stat p-3">
            @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
            <form method="POST" action="{{ route('cibles.store', $projet) }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-3"><input type="text" name="type_beneficiaire" class="form-control form-control-sm" placeholder="Type de bénéficiaire"></div>
                <div class="col-md-3"><input type="text" name="acteur" class="form-control form-control-sm" placeholder="Acteur"></div>
                <div class="col-md-5"><input type="text" name="probleme_specifique" class="form-control form-control-sm" placeholder="Problème spécifique"></div>
                <div class="col-md-1"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">+</button></div>
                <div class="col-md-6"><input type="text" name="attentes" class="form-control form-control-sm" placeholder="Attentes"></div>
                <div class="col-md-6"><input type="text" name="craintes" class="form-control form-control-sm" placeholder="Craintes"></div>
            </form>
            @endif
            <table class="table table-sm mb-0">
                <thead><tr><th>Type</th><th>Acteur</th><th>Problème spécifique</th><th>Attentes</th><th>Craintes</th><th></th></tr></thead>
                <tbody>
                @forelse($projet->cibles as $cible)
                <tr>
                    <td>{{ $cible->type_beneficiaire }}</td>
                    <td>{{ $cible->acteur }}</td>
                    <td>{{ $cible->probleme_specifique }}</td>
                    <td>{{ $cible->attentes }}</td>
                    <td>{{ $cible->craintes }}</td>
                    <td class="text-end">
                        @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editCible{{ $cible->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('cibles.destroy', $cible) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette cible ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <div class="modal fade" id="editCible{{ $cible->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <form method="POST" action="{{ route('cibles.update', $cible) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h6 class="modal-title fw-bold">Modifier la cible</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-2"><label class="form-label">Type de bénéficiaire</label><input type="text" name="type_beneficiaire" value="{{ $cible->type_beneficiaire }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Acteur</label><input type="text" name="acteur" value="{{ $cible->acteur }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Problème spécifique</label><input type="text" name="probleme_specifique" value="{{ $cible->probleme_specifique }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Attentes</label><input type="text" name="attentes" value="{{ $cible->attentes }}" class="form-control"></div>
                                        <div class="mb-1"><label class="form-label">Craintes</label><input type="text" name="craintes" value="{{ $cible->craintes }}" class="form-control"></div>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button><button class="btn text-white" style="background:#FF8200;">Enregistrer</button></div>
                                </form>
                            </div></div>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-muted text-center">Aucune cible enregistrée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Études --}}
    <div class="tab-pane fade" id="etudes">
        <div class="card card-stat p-3">
            @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
            <form method="POST" action="{{ route('etudes.store', $projet) }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-4"><input type="text" name="libelle" class="form-control form-control-sm" placeholder="Libellé de l'étude" required></div>
                <div class="col-md-3"><input type="text" name="mode_execution" class="form-control form-control-sm" placeholder="Mode d'exécution"></div>
                <div class="col-md-3"><input type="text" name="structure_realisation" class="form-control form-control-sm" placeholder="Structure de réalisation"></div>
                <div class="col-md-2"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">Ajouter</button></div>
                <div class="col-md-3"><input type="number" step="0.01" min="0" name="budget" class="form-control form-control-sm" placeholder="Budget"></div>
                <div class="col-md-3"><input type="date" name="date_demarrage" class="form-control form-control-sm"></div>
                <div class="col-md-3"><input type="text" name="duree" class="form-control form-control-sm" placeholder="Durée"></div>
                <div class="col-md-3"><input type="text" name="etat_execution" class="form-control form-control-sm" placeholder="État d'exécution"></div>
            </form>
            @endif
            <table class="table table-sm mb-0">
                <thead><tr><th>Libellé</th><th>Mode d'exécution</th><th>Budget</th><th>Démarrage</th><th>Durée</th><th>État</th><th></th></tr></thead>
                <tbody>
                @forelse($projet->etudes as $etude)
                <tr>
                    <td>{{ $etude->libelle }}</td>
                    <td>{{ $etude->mode_execution }}</td>
                    <td>{{ number_format($etude->budget,0,',',' ') }} FCFA</td>
                    <td>{{ optional($etude->date_demarrage)->format('d/m/Y') }}</td>
                    <td>{{ $etude->duree }}</td>
                    <td>{{ $etude->etat_execution }}</td>
                    <td class="text-end">
                        @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editEtude{{ $etude->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('etudes.destroy', $etude) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette étude ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <div class="modal fade" id="editEtude{{ $etude->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <form method="POST" action="{{ route('etudes.update', $etude) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h6 class="modal-title fw-bold">Modifier l'étude</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-2"><label class="form-label">Libellé</label><input type="text" name="libelle" value="{{ $etude->libelle }}" class="form-control" required></div>
                                        <div class="mb-2"><label class="form-label">Mode d'exécution</label><input type="text" name="mode_execution" value="{{ $etude->mode_execution }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Structure de réalisation</label><input type="text" name="structure_realisation" value="{{ $etude->structure_realisation }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Budget</label><input type="number" step="0.01" name="budget" value="{{ $etude->budget }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Date de démarrage</label><input type="date" name="date_demarrage" value="{{ optional($etude->date_demarrage)->format('Y-m-d') }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Durée</label><input type="text" name="duree" value="{{ $etude->duree }}" class="form-control"></div>
                                        <div class="mb-1"><label class="form-label">État d'exécution</label><input type="text" name="etat_execution" value="{{ $etude->etat_execution }}" class="form-control"></div>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button><button class="btn text-white" style="background:#FF8200;">Enregistrer</button></div>
                                </form>
                            </div></div>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-muted text-center">Aucune étude enregistrée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Marchés --}}
    <div class="tab-pane fade" id="marches">
        <div class="card card-stat p-3">
            @if(auth()->user()->hasRole(['administrateur','responsable_financier']))
            <form method="POST" action="{{ route('marches.store', $projet) }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-4"><input type="text" name="objet" class="form-control form-control-sm" placeholder="Objet du marché" required></div>
                <div class="col-md-2"><input type="text" name="etat" class="form-control form-control-sm" placeholder="État"></div>
                <div class="col-md-2"><input type="text" name="duree" class="form-control form-control-sm" placeholder="Durée"></div>
                <div class="col-md-2"><input type="number" step="0.01" min="0" name="cout" class="form-control form-control-sm" placeholder="Coût"></div>
                <div class="col-md-2"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">Ajouter</button></div>
                <div class="col-md-4"><input type="number" step="0.01" min="0" name="montant_engage" class="form-control form-control-sm" placeholder="Montant engagé"></div>
                <div class="col-md-4"><input type="number" step="0.01" min="0" name="montant_liquide" class="form-control form-control-sm" placeholder="Montant liquidé"></div>
                <div class="col-md-4"><input type="number" step="0.01" min="0" name="montant_paye" class="form-control form-control-sm" placeholder="Montant payé"></div>
            </form>
            @endif
            <table class="table table-sm mb-0">
                <thead><tr><th>Objet</th><th>État</th><th>Coût</th><th>Engagé</th><th>Liquidé</th><th>Payé</th><th></th></tr></thead>
                <tbody>
                @forelse($projet->marches as $marche)
                <tr>
                    <td>{{ $marche->objet }}</td>
                    <td>{{ $marche->etat }}</td>
                    <td>{{ number_format($marche->cout,0,',',' ') }} FCFA</td>
                    <td>{{ number_format($marche->montant_engage,0,',',' ') }} FCFA</td>
                    <td>{{ number_format($marche->montant_liquide,0,',',' ') }} FCFA</td>
                    <td>{{ number_format($marche->montant_paye,0,',',' ') }} FCFA</td>
                    <td class="text-end">
                        @if(auth()->user()->hasRole(['administrateur','responsable_financier']))
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editMarche{{ $marche->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('marches.destroy', $marche) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce marché ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <div class="modal fade" id="editMarche{{ $marche->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <form method="POST" action="{{ route('marches.update', $marche) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h6 class="modal-title fw-bold">Modifier le marché</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-2"><label class="form-label">Objet</label><input type="text" name="objet" value="{{ $marche->objet }}" class="form-control" required></div>
                                        <div class="mb-2"><label class="form-label">État</label><input type="text" name="etat" value="{{ $marche->etat }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Durée</label><input type="text" name="duree" value="{{ $marche->duree }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Coût</label><input type="number" step="0.01" name="cout" value="{{ $marche->cout }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Montant engagé</label><input type="number" step="0.01" name="montant_engage" value="{{ $marche->montant_engage }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Montant liquidé</label><input type="number" step="0.01" name="montant_liquide" value="{{ $marche->montant_liquide }}" class="form-control"></div>
                                        <div class="mb-1"><label class="form-label">Montant payé</label><input type="number" step="0.01" name="montant_paye" value="{{ $marche->montant_paye }}" class="form-control"></div>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button><button class="btn text-white" style="background:#FF8200;">Enregistrer</button></div>
                                </form>
                            </div></div>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-muted text-center">Aucun marché enregistré.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Charges récurrentes --}}
    <div class="tab-pane fade" id="charges">
        <div class="card card-stat p-3">
            @if(auth()->user()->hasRole(['administrateur','responsable_financier']))
            <form method="POST" action="{{ route('charges-recurrentes.store', $projet) }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-4"><input type="text" name="rubrique" class="form-control form-control-sm" placeholder="Rubrique" required></div>
                <div class="col-md-3"><input type="text" name="categorie" class="form-control form-control-sm" placeholder="Catégorie"></div>
                <div class="col-md-3"><input type="number" step="0.01" min="0" name="montant" class="form-control form-control-sm" placeholder="Montant" required></div>
                <div class="col-md-1"><input type="number" min="2000" max="2100" name="annee" class="form-control form-control-sm" placeholder="Année" required></div>
                <div class="col-md-1"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">+</button></div>
            </form>
            @endif
            <table class="table table-sm mb-0">
                <thead><tr><th>Rubrique</th><th>Catégorie</th><th>Montant</th><th>Année</th><th></th></tr></thead>
                <tbody>
                @forelse($projet->chargesRecurrentes as $charge)
                <tr>
                    <td>{{ $charge->rubrique }}</td>
                    <td>{{ $charge->categorie }}</td>
                    <td>{{ number_format($charge->montant,0,',',' ') }} FCFA</td>
                    <td>{{ $charge->annee }}</td>
                    <td class="text-end">
                        @if(auth()->user()->hasRole(['administrateur','responsable_financier']))
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editCharge{{ $charge->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('charges-recurrentes.destroy', $charge) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette charge récurrente ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <div class="modal fade" id="editCharge{{ $charge->id }}" tabindex="-1">
                            <div class="modal-dialog"><div class="modal-content">
                                <form method="POST" action="{{ route('charges-recurrentes.update', $charge) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h6 class="modal-title fw-bold">Modifier la charge récurrente</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-2"><label class="form-label">Rubrique</label><input type="text" name="rubrique" value="{{ $charge->rubrique }}" class="form-control" required></div>
                                        <div class="mb-2"><label class="form-label">Catégorie</label><input type="text" name="categorie" value="{{ $charge->categorie }}" class="form-control"></div>
                                        <div class="mb-2"><label class="form-label">Montant</label><input type="number" step="0.01" name="montant" value="{{ $charge->montant }}" class="form-control" required></div>
                                        <div class="mb-1"><label class="form-label">Année</label><input type="number" min="2000" max="2100" name="annee" value="{{ $charge->annee }}" class="form-control" required></div>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button><button class="btn text-white" style="background:#FF8200;">Enregistrer</button></div>
                                </form>
                            </div></div>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-muted text-center">Aucune charge récurrente enregistrée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Objectifs spécifiques --}}
    <div class="tab-pane fade" id="objectifs">
        <div class="card card-stat p-3">
            @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
            <form method="POST" action="{{ route('objectifs-specifiques.store', $projet) }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-10"><input type="text" name="libelle" class="form-control form-control-sm" placeholder="Libellé de l'objectif spécifique" required></div>
                <div class="col-md-2"><button class="btn btn-sm text-white w-100" style="background:#FF8200;">Ajouter</button></div>
            </form>
            @endif
            <ul class="list-group list-group-flush">
                @forelse($projet->objectifsSpecifiques as $obj)
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span>{{ $obj->libelle }}</span>
                    @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
                    <form action="{{ route('objectifs-specifiques.destroy', $obj) }}" method="POST" onsubmit="return confirm('Supprimer cet objectif ?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </li>
                @empty
                <li class="list-group-item px-0 text-muted">Aucun objectif spécifique enregistré.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Financements --}}
    <div class="tab-pane fade" id="financier">
        <div class="card card-stat p-3">
            <h6 class="fw-bold mb-3">Financements</h6>
            <table class="table table-sm">
                <thead><tr><th>Référence</th><th>Source</th><th>Montant engagé</th><th>Date</th><th>Décaissé</th></tr></thead>
                <tbody>
                @forelse($projet->financements as $f)
                    <tr>
                        <td>{{ $f->reference }}</td>
                        <td>{{ $f->source_libelle }}</td>
                        <td>{{ number_format($f->montant_engage,0,',',' ') }} FCFA</td>
                        <td>{{ $f->date->format('d/m/Y') }}</td>
                        <td>{{ number_format($f->decaissements->sum('montant'),0,',',' ') }} FCFA</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center">Aucun financement enregistré.</td></tr>
                @endforelse
                </tbody>
            </table>
            <a href="{{ route('financements.create') }}" class="btn btn-sm btn-outline-secondary">Ajouter un financement</a>
        </div>
        <div class="card card-stat p-3 mt-3">
            <h6 class="fw-bold mb-3">Dépenses</h6>
            <table class="table table-sm">
                <thead><tr><th>Référence</th><th>Libellé</th><th>Montant</th><th>Date</th></tr></thead>
                <tbody>
                @forelse($projet->depenses as $d)
                    <tr><td>{{ $d->reference }}</td><td>{{ $d->libelle }}</td><td>{{ number_format($d->montant,0,',',' ') }} FCFA</td><td>{{ $d->date->format('d/m/Y') }}</td></tr>
                @empty
                    <tr><td colspan="4" class="text-muted text-center">Aucune dépense enregistrée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Rapports --}}
    <div class="tab-pane fade" id="rapports">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold m-0">Rapports du projet</h6>
                <a href="{{ route('rapports.create') }}?projet_id={{ $projet->id }}" class="btn btn-sm btn-outline-secondary">Nouveau rapport</a>
            </div>
            <ul class="list-unstyled small">
                @forelse($projet->rapports as $rapport)
                <li class="border-bottom py-2 d-flex justify-content-between">
                    <div>
                        <a href="{{ route('rapports.show', $rapport) }}">{{ $rapport->titre }}</a>
                        <div class="text-muted">{{ str_replace('_',' ',$rapport->type) }} · {{ $rapport->date->format('d/m/Y') }} · par {{ $rapport->utilisateur->prenom ?? '' }} {{ $rapport->utilisateur->nom ?? '' }}</div>
                    </div>
                    @if($rapport->fichier)<a href="{{ route('rapports.download', $rapport) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-download"></i></a>@endif
                </li>
                @empty
                <li class="text-muted">Aucun rapport enregistré.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Pièces justificatives --}}
    <div class="tab-pane fade" id="pieces">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold m-0">Pièces justificatives</h6>
                <a href="{{ route('pieces-justificatives.create') }}?projet_id={{ $projet->id }}" class="btn btn-sm btn-outline-secondary">Ajouter une pièce</a>
            </div>
            <ul class="list-unstyled small">
                @forelse($projet->piecesJustificatives as $piece)
                <li class="border-bottom py-2 d-flex justify-content-between">
                    <div>{{ $piece->libelle ?? ucfirst($piece->categorie) }} <span class="badge bg-light text-dark border">{{ $piece->categorie }}</span>
                        <div class="text-muted">Déposé par {{ $piece->utilisateur->prenom ?? '' }} {{ $piece->utilisateur->nom ?? '' }}</div>
                    </div>
                    <a href="{{ route('pieces-justificatives.download', $piece) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-download"></i></a>
                </li>
                @empty
                <li class="text-muted">Aucune pièce justificative enregistrée.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
