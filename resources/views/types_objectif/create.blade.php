@extends('layouts.app')
@section('page-title', 'Nouveau type d\'objectif')
@section('content')
<div class="card card-stat p-4" style="max-width:500px;">
    <h5 class="fw-bold mb-3">Nouveau type d'objectif</h5>
    <form method="POST" action="{{ route('types-objectif.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control" required placeholder="ex : Objectif spécifique, Objectif global, ODD">
        </div>
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('types-objectif.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
