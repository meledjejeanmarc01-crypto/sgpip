@extends('layouts.app')
@section('page-title', 'Détail du bailleur')
@section('content')
<div class="card card-stat p-4 mb-3">
    <h5 class="fw-bold">{{ $bailleur->nom }} @if($bailleur->sigle)<span class="text-muted">({{ $bailleur->sigle }})</span>@endif</h5>
    <p class="text-muted mb-1">Type : {{ $bailleur->typeBailleur->libelle ?? '—' }}</p>
    <p class="text-muted mb-0">Contact : {{ $bailleur->contact ?? '—' }}</p>
</div>
<div class="row g-3">
    <div class="col-md-6">
        <div class="card card-stat p-3">
            <h6 class="fw-bold">Financements ({{ $bailleur->financements->count() }})</h6>
            <table class="table table-sm mb-0">
                <thead><tr><th>Référence</th><th>Projet</th><th>Montant engagé</th></tr></thead>
                <tbody>
                @foreach($bailleur->financements as $f)
                    <tr><td>{{ $f->reference }}</td><td>{{ $f->projet->intitule ?? '—' }}</td><td>{{ number_format($f->montant_engage,0,',',' ') }} FCFA</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stat p-3">
            <h6 class="fw-bold">Décaissements ({{ $bailleur->decaissements->count() }})</h6>
            <table class="table table-sm mb-0">
                <thead><tr><th>Référence</th><th>Date</th><th>Montant</th></tr></thead>
                <tbody>
                @foreach($bailleur->decaissements as $d)
                    <tr><td>{{ $d->reference }}</td><td>{{ $d->date->format('d/m/Y') }}</td><td>{{ number_format($d->montant,0,',',' ') }} FCFA</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
