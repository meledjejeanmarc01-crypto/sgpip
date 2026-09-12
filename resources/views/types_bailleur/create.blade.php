@extends('layouts.app')
@section('page-title', 'Nouveau type de bailleur')
@section('content')
<div class="card card-stat p-4" style="max-width:500px;">
    <h5 class="fw-bold mb-3">Nouveau type de bailleur</h5>
    <form method="POST" action="{{ route('types-bailleur.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control" required>
        </div>
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('types-bailleur.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
