@extends('layouts.app')
@section('page-title', 'Modifier la réforme')
@section('content')
<div class="card card-stat p-4" style="max-width:950px;">
    <h5 class="fw-bold mb-3">Modifier la réforme</h5>
    <form method="POST" action="{{ route('reformes.update', $reforme) }}">
        @csrf @method('PUT')
        @include('reformes.form')
        <button class="btn text-white" style="background:#FF8200;">Mettre à jour</button>
        <a href="{{ route('reformes.show', $reforme) }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
