@extends('layouts.app')
@section('page-title', 'Modifier le secteur')
@section('content')
<div class="card card-stat p-4" style="max-width:500px;">
    <h5 class="fw-bold mb-3">Modifier le secteur</h5>
    <form method="POST" action="{{ route('secteurs.update', $secteur) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle', $secteur->libelle) }}" class="form-control" required>
        </div>
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('secteurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
