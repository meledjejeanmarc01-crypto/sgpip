@extends('layouts.app')
@section('page-title', 'Nouvelle action PND')
@section('content')
<div class="card card-stat p-4" style="max-width:650px;">
    <h5 class="fw-bold mb-3">Nouvelle action PND</h5>
    <form method="POST" action="{{ route('actions-pnd.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('actions-pnd.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
