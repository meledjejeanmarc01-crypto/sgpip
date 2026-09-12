@extends('layouts.app')
@section('page-title', 'Modifier le rapport')
@section('content')
<div class="card card-stat p-4" style="max-width:750px;">
    <h5 class="fw-bold mb-3">Modifier le rapport</h5>
    <form method="POST" action="{{ route('rapports.update', $rapport) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('rapports.form')
        <button class="btn text-white" style="background:#FF8200;">Mettre à jour</button>
        <a href="{{ route('rapports.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
