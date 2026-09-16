@extends('layouts.app')
@section('page-title', 'Modifier le type d\'analyse causale')
@section('content')
<div class="card card-stat p-4" style="max-width:500px;">
    <h5 class="fw-bold mb-3">Modifier le type d'analyse causale</h5>
    <form method="POST" action="{{ route('types-analyse-causale.update', $type) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle', $type->libelle) }}" class="form-control" required>
        </div>
        <button class="btn text-white" style="background:#FF8200;">Mettre à jour</button>
        <a href="{{ route('types-analyse-causale.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
