@extends('layouts.app')
@section('page-title', 'Détail de la réforme')
@section('content')
<div class="card card-stat p-4 mb-3">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h5 class="fw-bold mb-1">{{ $reforme->libelle }}</h5>
            <span class="badge bg-light text-dark border">{{ str_replace('_',' ',$reforme->statut) }}</span>
        </div>
        @if(auth()->user()->hasRole(['administrateur','gestionnaire_projet']))
        <div>
            <a href="{{ route('reformes.edit', $reforme) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i> Modifier</a>
            <form action="{{ route('reformes.destroy', $reforme) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette réforme ?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Supprimer</button>
            </form>
        </div>
        @endif
    </div>
    <hr>
    <div class="row small">
        <div class="col-md-3"><strong>Structure pilote :</strong> {{ $reforme->structure->libelle ?? '—' }}</div>
        <div class="col-md-3"><strong>Axe :</strong> {{ $reforme->axe->libelle ?? '—' }}</div>
        <div class="col-md-3"><strong>Période :</strong> {{ $reforme->annee_debut }} - {{ $reforme->annee_fin }}</div>
        <div class="col-md-3"><strong>Transmission SGG :</strong> {{ optional($reforme->date_transmission_sgg)->format('d/m/Y') ?? '—' }}</div>
    </div>
    <div class="row small mt-2">
        <div class="col-md-3"><strong>Localité :</strong> {{ $reforme->localite ?? '—' }}</div>
        <div class="col-md-3"><strong>Budget global :</strong> {{ number_format($reforme->budget_global,0,',',' ') }} FCFA</div>
        <div class="col-md-3"><strong>Montant État :</strong> {{ number_format($reforme->montant_etat,0,',',' ') }} FCFA</div>
        <div class="col-md-3"><strong>Montant autres bailleurs :</strong> {{ number_format($reforme->montant_autres_bailleurs,0,',',' ') }} FCFA</div>
    </div>
    <div class="row small mt-2">
        <div class="col-md-6"><strong>Taux exécution année précédente :</strong> {{ $reforme->taux_execution_annee_precedente ?? '—' }}%</div>
        <div class="col-md-6"><strong>Taux exécution prévisionnel :</strong> {{ $reforme->taux_execution_previsionnel ?? '—' }}%</div>
    </div>
    @if($reforme->resultat_global_attendu)<p class="mt-3 small mb-1"><strong>Résultat global attendu :</strong> {{ $reforme->resultat_global_attendu }}</p>@endif
    @if($reforme->livrables_attendus)<p class="small mb-1"><strong>Livrables attendus :</strong> {{ $reforme->livrables_attendus }}</p>@endif
    @if($reforme->indicateurs)<p class="small mb-1"><strong>Indicateurs :</strong> {{ $reforme->indicateurs }}</p>@endif
    @if($reforme->observations)<p class="small mb-0"><strong>Observations :</strong> {{ $reforme->observations }}</p>@endif
</div>

<div class="card card-stat p-3">
    <h6 class="fw-bold mb-3">Cibles trimestrielles</h6>
    <div class="row small text-center">
        <div class="col-md-3"><div class="text-muted">Trimestre 1</div><div class="fw-semibold">{{ $reforme->cible_trimestre_1 ?: '—' }}</div></div>
        <div class="col-md-3"><div class="text-muted">Trimestre 2</div><div class="fw-semibold">{{ $reforme->cible_trimestre_2 ?: '—' }}</div></div>
        <div class="col-md-3"><div class="text-muted">Trimestre 3</div><div class="fw-semibold">{{ $reforme->cible_trimestre_3 ?: '—' }}</div></div>
        <div class="col-md-3"><div class="text-muted">Trimestre 4</div><div class="fw-semibold">{{ $reforme->cible_trimestre_4 ?: '—' }}</div></div>
    </div>
</div>
@endsection
