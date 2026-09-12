@extends('layouts.app')
@section('page-title', 'Nouvelle fiche PIP')
@section('content')
<div class="card card-stat p-4" style="max-width:650px;">
    <h5 class="fw-bold mb-3">Nouvelle fiche PIP</h5>
    <form method="POST" action="{{ route('fiches-pip.store') }}">
        @csrf
        @include('fiches_pip.form')
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('fiches-pip.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
