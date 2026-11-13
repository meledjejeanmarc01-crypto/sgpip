@extends('layouts.app')
@section('page-title', 'Mon mot de passe')
@section('content')
<div class="card card-stat p-4" style="max-width:520px;">
    <h5 class="fw-bold mb-3">Modifier mon mot de passe</h5>
    <form method="POST" action="{{ route('mot-de-passe.update') }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Mot de passe actuel</label>
            <input type="password" name="password_actuel" class="form-control" required autocomplete="current-password">
        </div>
        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" required minlength="8" autocomplete="new-password">
            <div class="form-text">8 caractères minimum.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirmation du nouveau mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
        </div>
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
