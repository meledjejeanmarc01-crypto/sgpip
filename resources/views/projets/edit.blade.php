@extends('layouts.app')
@section('page-title', 'Modifier le projet')
@section('content')
<div class="card card-stat p-4" style="max-width:900px;">
    <h5 class="fw-bold mb-3">Modifier le projet</h5>
    <form method="POST" action="{{ route('projets.update', $projet) }}">
        @csrf @method('PUT')
        @include('projets.form')
        <div class="d-flex justify-content-center gap-3 mt-4">
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('projets.show', $projet) }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
