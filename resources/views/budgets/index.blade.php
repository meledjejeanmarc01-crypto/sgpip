@extends('layouts.app')

@section('title', 'Budgets - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-wallet2"></i> Budgets</h2>
            <p class="text-muted mb-0">Vue d'ensemble des lignes budgétaires, tous projets confondus.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBudget">
            <i class="bi bi-plus-lg"></i> Nouveau budget
        </button>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Montant total prévu</div>
                    <div class="fs-4 fw-bold">{{ number_format($totalPrevu, 0, ',', ' ') }} FCFA</div>
                </div>
            </div>
        </div>
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
            <select name="exercice" class="form-select" onchange="this.form.submit()">
                <option value="">Tous les exercices</option>
                @foreach($exercices as $ex)
                    <option value="{{ $ex }}" @selected(request('exercice') == $ex)>{{ $ex }}</option>
                @endforeach
            </select>
        </div>
        @if(request('projet_id') || request('exercice'))
            <div class="col-auto"><a href="{{ route('budgets.index') }}" class="btn btn-outline-secondary">Réinitialiser</a></div>
        @endif
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($budgets->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Projet</th><th>Exercice</th><th>Montant prévu</th><th>Source de financement</th><th>Date</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @foreach($budgets as $budget)
                        <tr>
                            <td><a href="{{ route('projets.show', $budget->projet) }}" class="small">{{ $budget->projet?->reference }}</a></td>
                            <td>{{ $budget->exercice }}</td>
                            <td>{{ number_format($budget->montant_prevu, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $budget->source_financement ?? '—' }}</td>
                            <td>{{ $budget->date?->format('d/m/Y') ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('projets.show', $budget->projet) }}" class="btn btn-sm btn-outline-primary" title="Voir le projet"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-warning" title="Modifier" data-bs-toggle="modal" data-bs-target="#modalEditBudget{{ $budget->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce budget ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <tr class="d-none"><td colspan="6">
                            <div class="modal fade" id="modalEditBudget{{ $budget->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('budgets.update', $budget) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header"><h5 class="modal-title">Modifier le budget</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                            <div class="modal-body">
                                                <p class="text-muted small">{{ $budget->projet?->reference }} — {{ $budget->projet?->intitule }}</p>
                                                <div class="row g-2 mb-2">
                                                    <div class="col-6"><label class="form-label">Montant prévu</label><input type="number" step="0.01" min="0" name="montant_prevu" class="form-control" value="{{ $budget->montant_prevu }}" required></div>
                                                    <div class="col-6"><label class="form-label">Exercice</label><input type="number" name="exercice" class="form-control" value="{{ $budget->exercice }}" required></div>
                                                </div>
                                                <div class="mb-2"><label class="form-label">Source de financement</label><input type="text" name="source_financement" class="form-control" value="{{ $budget->source_financement }}"></div>
                                                <div class="mb-2"><label class="form-label">Date</label><input type="date" name="date" class="form-control" value="{{ $budget->date?->format('Y-m-d') }}"></div>
                                                <div class="mb-2"><label class="form-label">Observation</label><textarea name="observation" class="form-control" rows="2">{{ $budget->observation }}</textarea></div>
                                            </div>
                                            <div class="modal-footer"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td></tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-4 mb-0">Aucun budget trouvé. Utilisez le bouton « Nouveau budget » ci-dessus, ou ajoutez-en un depuis la fiche d'un projet.</p>
            @endif
        </div>
        <div class="card-footer bg-white">{{ $budgets->links() }}</div>
    </div>
</div>

{{-- MODAL NOUVEAU BUDGET --}}
<div class="modal fade" id="modalBudget" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formBudget" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouveau budget</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Projet</label>
                        <select id="budgetProjetSelect" class="form-select" required>
                            <option value="">-- Sélectionner un projet --</option>
                            @foreach($projets as $p)
                                <option value="{{ $p->id }}">{{ $p->reference }} — {{ $p->intitule }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label">Montant prévu</label><input type="number" step="0.01" min="0" name="montant_prevu" class="form-control" required></div>
                        <div class="col-6"><label class="form-label">Exercice</label><input type="number" name="exercice" class="form-control" placeholder="2026" required></div>
                    </div>
                    <div class="mb-2"><label class="form-label">Source de financement</label><input type="text" name="source_financement" class="form-control" placeholder="Budget de l'État, bailleur..."></div>
                    <div class="mb-2"><label class="form-label">Date</label><input type="date" name="date" class="form-control"></div>
                    <div class="mb-2"><label class="form-label">Observation</label><textarea name="observation" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary" id="btnBudgetSubmit" disabled>Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('budgetProjetSelect').addEventListener('change', function () {
        const form = document.getElementById('formBudget');
        const btn = document.getElementById('btnBudgetSubmit');
        if (this.value) {
            form.action = '/projets/' + this.value + '/budgets';
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    });
</script>
@endpush
@endsection
