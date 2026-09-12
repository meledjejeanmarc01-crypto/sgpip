@extends('layouts.app')
@section('page-title', 'Nouveau rapport')
@section('content')
<div class="card card-stat p-4" style="max-width:750px;">
    <h5 class="fw-bold mb-3">Nouveau rapport</h5>
    <form method="POST" action="{{ route('rapports.store') }}" enctype="multipart/form-data">
        @csrf
        @include('rapports.form')
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('rapports.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
