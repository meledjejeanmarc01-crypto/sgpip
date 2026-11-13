@extends('layouts.app')
@section('page-title', "Modifier l'action PND")
@section('content')
<div class="card card-stat p-4" style="max-width:650px;">
    <h5 class="fw-bold mb-3">Modifier l'action PND</h5>
    <form method="POST" action="{{ route('actions-pnd.update', $action) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle', $action->libelle) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $action->description) }}</textarea>
        </div>
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('actions-pnd.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
