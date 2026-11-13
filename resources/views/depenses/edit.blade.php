@extends('layouts.app')
@section('page-title', 'Modifier la dépense')
@section('content')
<div class="card card-stat p-4" style="max-width:750px;">
    <h5 class="fw-bold mb-3">Modifier la dépense</h5>
    <form method="POST" action="{{ route('depenses.update', $depense) }}">
        @csrf @method('PUT')
        @include('depenses.form')
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('depenses.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
