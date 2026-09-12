@extends('layouts.app')
@section('page-title', 'Nouveau financement')
@section('content')
<div class="card card-stat p-4" style="max-width:800px;">
    <h5 class="fw-bold mb-3">Nouveau financement</h5>
    <form method="POST" action="{{ route('financements.store') }}">
        @csrf
        @include('financements.form')
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('financements.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
