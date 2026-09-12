@extends('layouts.app')
@section('page-title', 'Nouvelle zone')
@section('content')
<div class="card card-stat p-4" style="max-width:650px;">
    <h5 class="fw-bold mb-3">Nouvelle zone de localisation</h5>
    <form method="POST" action="{{ route('zones.store') }}">
        @csrf
        @include('zones.form')
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('zones.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
