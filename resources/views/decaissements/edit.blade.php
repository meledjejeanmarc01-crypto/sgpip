@extends('layouts.app')
@section('page-title', 'Modifier le décaissement')
@section('content')
<div class="card card-stat p-4" style="max-width:750px;">
    <h5 class="fw-bold mb-3">Modifier le décaissement</h5>
    <form method="POST" action="{{ route('decaissements.update', $decaissement) }}">
        @csrf @method('PUT')
        @include('decaissements.form')
        <button class="btn text-white" style="background:#FF8200;">Mettre à jour</button>
        <a href="{{ route('decaissements.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
