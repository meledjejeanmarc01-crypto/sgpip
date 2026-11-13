@extends('layouts.app')
@section('page-title', 'Modifier la structure')
@section('content')
<div class="card card-stat p-4" style="max-width:600px;">
    <h5 class="fw-bold mb-3">Modifier la structure</h5>
    <form method="POST" action="{{ route('structures.update', $structure) }}">
        @csrf @method('PUT')
        @include('structures.form')
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('structures.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
