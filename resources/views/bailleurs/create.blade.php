@extends('layouts.app')
@section('page-title', 'Nouveau bailleur')
@section('content')
<div class="card card-stat p-4" style="max-width:600px;">
    <h5 class="fw-bold mb-3">Nouveau bailleur</h5>
    <form method="POST" action="{{ route('bailleurs.store') }}">
        @csrf
        @include('bailleurs.form')
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('bailleurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
