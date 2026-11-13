@extends('layouts.app')
@section('page-title', 'Nouvel utilisateur')
@section('content')
<div class="card card-stat p-4" style="max-width:650px;">
    <h5 class="fw-bold mb-3">Nouvel utilisateur</h5>
    <form method="POST" action="{{ route('utilisateurs.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Prénom</label><input type="text" name="prenom" value="{{ old('prenom') }}" class="form-control" required></div>
            <div class="col-md-6 mb-3"><label class="form-label">Nom</label><input type="text" name="nom" value="{{ old('nom') }}" class="form-control" required></div>
        </div>
        <div class="mb-3"><label class="form-label">E-mail</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Mot de passe</label><input type="password" name="password" class="form-control" required></div>
            <div class="col-md-6 mb-3"><label class="form-label">Confirmation</label><input type="password" name="password_confirmation" class="form-control" required></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Rôle</label>
            <select name="role" class="form-select" required>
                @foreach(['administrateur'=>'Administrateur','gestionnaire_projet'=>'Gestionnaire de projet','consultant'=>'Consultant'] as $val=>$label)
                    <option value="{{ $val }}" @selected(old('role')==$val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
