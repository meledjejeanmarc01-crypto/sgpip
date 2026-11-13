@extends('layouts.app')
@section('page-title', 'Nouvelle structure')
@section('content')
<div class="card card-stat p-4" style="max-width:600px;">
    <h5 class="fw-bold mb-3">Nouvelle structure</h5>
    <form method="POST" action="{{ route('structures.store') }}">
        @csrf
        @include('structures.form')
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('structures.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
