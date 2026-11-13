@extends('layouts.app')
@section('page-title', 'Nouveau programme')
@section('content')
<div class="card card-stat p-4" style="max-width:750px;">
    <h5 class="fw-bold mb-3">Nouveau programme</h5>
    <form method="POST" action="{{ route('programmes.store') }}">
        @csrf
        @include('programmes.form')
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('programmes.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
