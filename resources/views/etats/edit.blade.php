@extends('layouts.app')
@section('page-title', 'Modifier la fiche État')
@section('content')
<div class="card card-stat p-4" style="max-width:600px;">
    <h5 class="fw-bold mb-3">Modifier la fiche « État »</h5>
    <form method="POST" action="{{ route('etats.update', $etat) }}">
        @csrf @method('PUT')
        @include('etats.form')
        <button class="btn text-white" style="background:#FF8200;">Mettre à jour</button>
        <a href="{{ route('etats.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
