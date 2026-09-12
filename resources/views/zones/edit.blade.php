@extends('layouts.app')
@section('page-title', 'Modifier la zone')
@section('content')
<div class="card card-stat p-4" style="max-width:650px;">
    <h5 class="fw-bold mb-3">Modifier la zone de localisation</h5>
    <form method="POST" action="{{ route('zones.update', $zone) }}">
        @csrf @method('PUT')
        @include('zones.form')
        <button class="btn text-white" style="background:#FF8200;">Mettre à jour</button>
        <a href="{{ route('zones.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
