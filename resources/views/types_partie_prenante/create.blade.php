@extends('layouts.app')
@section('page-title', 'Nouveau type de partie prenante')
@section('content')
<div class="card card-stat p-4" style="max-width:500px;">
    <h5 class="fw-bold mb-3">Nouveau type de partie prenante</h5>
    <form method="POST" action="{{ route('types-partie-prenante.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control" required placeholder="ex : Maître d'ouvrage, Maître d'œuvre">
        </div>
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('types-partie-prenante.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
