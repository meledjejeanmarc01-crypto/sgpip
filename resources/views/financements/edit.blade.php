@extends('layouts.app')
@section('page-title', 'Modifier le financement')
@section('content')
<div class="card card-stat p-4" style="max-width:800px;">
    <h5 class="fw-bold mb-3">Modifier le financement</h5>
    <form method="POST" action="{{ route('financements.update', $financement) }}">
        @csrf @method('PUT')
        @include('financements.form')
        <button class="btn text-white" style="background:#FF8200;">Mettre à jour</button>
        <a href="{{ route('financements.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>

@php($convention = $financement->conventionFinancement)
<div class="card card-stat p-4 mt-3" style="max-width:800px;">
    <h5 class="fw-bold mb-3">Convention de financement</h5>
    <form method="POST" action="{{ $convention ? route('conventions-financement.update', $convention) : route('conventions-financement.store', $financement) }}">
        @csrf
        @if($convention) @method('PUT') @endif
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Type d'accord</label>
                <input type="text" name="type_accord" value="{{ old('type_accord', $convention->type_accord ?? '') }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nature du financement</label>
                <input type="text" name="nature_financement" value="{{ old('nature_financement', $convention->nature_financement ?? '') }}" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Date limite de tirage</label>
                <input type="date" name="date_limite_tirage" value="{{ old('date_limite_tirage', optional($convention->date_limite_tirage ?? null)->format('Y-m-d')) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Niveau d'avancement des négociations</label>
                <input type="text" name="niveau_avancement_negociations" value="{{ old('niveau_avancement_negociations', $convention->niveau_avancement_negociations ?? '') }}" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">N° accord signé</label>
                <input type="text" name="numero_accord_signe" value="{{ old('numero_accord_signe', $convention->numero_accord_signe ?? '') }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Montant</label>
                <input type="number" step="0.01" name="montant" value="{{ old('montant', $convention->montant ?? '') }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Date de signature</label>
                <input type="date" name="date_signature" value="{{ old('date_signature', optional($convention->date_signature ?? null)->format('Y-m-d')) }}" class="form-control">
            </div>
        </div>
        <button class="btn text-white" style="background:#FF8200;">{{ $convention ? 'Mettre à jour' : 'Enregistrer' }} la convention</button>
    </form>
    @if($convention)
    <form action="{{ route('conventions-financement.destroy', $convention) }}" method="POST" class="d-inline mt-2" onsubmit="return confirm('Supprimer cette convention de financement ?');">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger">Supprimer la convention</button>
    </form>
    @endif
</div>
@endsection
