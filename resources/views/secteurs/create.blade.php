@extends('layouts.app')
@section('page-title', 'Nouveau secteur')
@section('content')
<div class="card card-stat p-4" style="max-width:500px;">
    <h5 class="fw-bold mb-3">Nouveau secteur</h5>
    <form method="POST" action="{{ route('secteurs.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control" required>
        </div>
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('secteurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
