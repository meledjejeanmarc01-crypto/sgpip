@extends('layouts.app')
@section('page-title', 'Nouvel acteur')
@section('content')
<div class="card card-stat p-4" style="max-width:600px;">
    <h5 class="fw-bold mb-3">Nouvel acteur</h5>
    <form method="POST" action="{{ route('acteurs.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rôle</label>
            <input type="text" name="role" value="{{ old('role') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Groupe d'acteur</label>
            <select name="groupe_acteur_id" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach($groupes as $g)
                    <option value="{{ $g->id }}" @selected(old('groupe_acteur_id') == $g->id)>{{ $g->libelle }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('acteurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
