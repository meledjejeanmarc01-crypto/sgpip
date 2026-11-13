@extends('layouts.app')
@section('page-title', 'Modifier la fiche PIP')
@section('content')
<div class="card card-stat p-4" style="max-width:650px;">
    <h5 class="fw-bold mb-3">Modifier la fiche PIP</h5>
    <form method="POST" action="{{ route('fiches-pip.update', $fiche) }}">
        @csrf @method('PUT')
        @include('fiches_pip.form')
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('fiches-pip.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
