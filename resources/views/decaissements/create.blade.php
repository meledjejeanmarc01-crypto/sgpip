@extends('layouts.app')
@section('page-title', 'Nouveau décaissement')
@section('content')
<div class="card card-stat p-4" style="max-width:750px;">
    <h5 class="fw-bold mb-3">Nouveau décaissement</h5>
    <form method="POST" action="{{ route('decaissements.store') }}">
        @csrf
        @include('decaissements.form')
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('decaissements.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
