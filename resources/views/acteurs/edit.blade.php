@extends('layouts.app')
@section('page-title', 'Modifier l\'acteur')
@section('content')
<div class="card card-stat p-4" style="max-width:600px;">
    <h5 class="fw-bold mb-3">Modifier l'acteur</h5>
    <form method="POST" action="{{ route('acteurs.update', $acteur) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle', $acteur->libelle) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fonction</label>
            <input type="text" name="role" value="{{ old('role', $acteur->role) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Groupe d'acteur</label>
            <select name="groupe_acteur_id" class="form-select" data-creer-url="{{ route('groupes-acteur.store') }}" data-creer-nom="Nom du nouveau groupe d'acteur">
                <option value="">-- Aucun --</option>
                @foreach($groupes as $g)
                    <option value="{{ $g->id }}" @selected(old('groupe_acteur_id', $acteur->groupe_acteur_id) == $g->id)>{{ $g->libelle }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Partie prenante</label>
            <select name="partie_prenante_id" class="form-select">
                <option value="">-- Aucune --</option>
                @foreach($partiesPrenantes as $pp)
                    <option value="{{ $pp->id }}" @selected(old('partie_prenante_id', $acteur->partie_prenante_id) == $pp->id)>{{ $pp->libelle }}@if($pp->projet) — {{ $pp->projet->reference }}@endif</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('acteurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
