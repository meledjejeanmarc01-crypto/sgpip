@extends('layouts.app')
@section('page-title', 'Modifier le bailleur')
@section('content')
<div class="card card-stat p-4" style="max-width:600px;">
    <h5 class="fw-bold mb-3">Modifier le bailleur</h5>
    <form method="POST" action="{{ route('bailleurs.update', $bailleur) }}">
        @csrf @method('PUT')
        @include('bailleurs.form')
        <button class="btn btn-brand">Mettre à jour</button>
        <a href="{{ route('bailleurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
