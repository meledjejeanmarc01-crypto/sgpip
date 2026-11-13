@extends('layouts.app')
@section('page-title', 'Modifier le programme')
@section('content')
<div class="card card-stat p-4" style="max-width:750px;">
    <h5 class="fw-bold mb-3">Modifier le programme</h5>
    <form method="POST" action="{{ route('programmes.update', $programme) }}">
        @csrf @method('PUT')
        @include('programmes.form')
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('programmes.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
