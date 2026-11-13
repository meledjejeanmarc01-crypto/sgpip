@extends('layouts.app')
@section('page-title', 'Nouvelle réforme')
@section('content')
<div class="card card-stat p-4" style="max-width:950px;">
    <h5 class="fw-bold mb-3">Nouvelle réforme</h5>
    <form method="POST" action="{{ route('reformes.store') }}">
        @csrf
        @include('reformes.form')
        <div class="d-flex justify-content-center gap-3 mt-4">
            <button type="submit" class="btn btn-brand">Enregistrer</button>
            <a href="{{ route('reformes.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
