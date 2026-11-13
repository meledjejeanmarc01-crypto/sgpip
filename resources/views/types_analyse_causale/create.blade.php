@extends('layouts.app')
@section('page-title', 'Nouveau type d\'analyse causale')
@section('content')
<div class="card card-stat p-4" style="max-width:500px;">
    <h5 class="fw-bold mb-3">Nouveau type d'analyse causale</h5>
    <form method="POST" action="{{ route('types-analyse-causale.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control" required placeholder="ex : Cause immédiate, Cause sous-jacente, Cause structurelle">
        </div>
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('types-analyse-causale.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
