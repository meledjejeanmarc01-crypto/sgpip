@extends('layouts.app')
@section('page-title', 'Nouvelle réforme')
@section('content')
<div class="card card-stat p-4" style="max-width:950px;">
    <h5 class="fw-bold mb-3">Nouvelle réforme</h5>
    <form method="POST" action="{{ route('reformes.store') }}">
        @csrf
        @include('reformes.form')
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('reformes.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
