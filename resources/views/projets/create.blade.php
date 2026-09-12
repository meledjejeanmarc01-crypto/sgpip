@extends('layouts.app')
@section('page-title', 'Nouveau projet')
@section('content')
<div class="card card-stat p-4" style="max-width:900px;">
    <h5 class="fw-bold mb-3">Nouveau projet d'investissement public</h5>
    <form method="POST" action="{{ route('projets.store') }}">
        @csrf
        @include('projets.form')
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('projets.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
