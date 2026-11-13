@extends('layouts.app')
@section('page-title', "Modifier l'utilisateur")
@section('content')
<div class="card card-stat p-4" style="max-width:650px;">
    <h5 class="fw-bold mb-3">Modifier l'utilisateur</h5>
    <form method="POST" action="{{ route('utilisateurs.update', $utilisateur) }}">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Prénom</label><input type="text" name="prenom" value="{{ old('prenom', $utilisateur->prenom) }}" class="form-control" required></div>
            <div class="col-md-6 mb-3"><label class="form-label">Nom</label><input type="text" name="nom" value="{{ old('nom', $utilisateur->nom) }}" class="form-control" required></div>
        </div>
        <div class="mb-3"><label class="form-label">E-mail</label><input type="email" name="email" value="{{ old('email', $utilisateur->email) }}" class="form-control" required></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Nouveau mot de passe (facultatif)</label><input type="password" name="password" class="form-control"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Confirmation</label><input type="password" name="password_confirmation" class="form-control"></div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label">Rôle</label>
                <select name="role" class="form-select" required>
                    @foreach(['administrateur'=>'Administrateur','gestionnaire_projet'=>'Gestionnaire de projet','consultant'=>'Consultant'] as $val=>$label)
                        <option value="{{ $val }}" @selected(old('role', $utilisateur->role)==$val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="actif" value="1" id="actif" @checked(old('actif', $utilisateur->actif)) >
                    <label class="form-check-label" for="actif">Compte actif</label>
                </div>
            </div>
        </div>
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
