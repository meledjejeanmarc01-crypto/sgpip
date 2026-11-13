
@extends('layouts.app')

@section('page-title', 'Nouveau projet')

@section('content')
<div class="card card-stat p-4" style="max-width:900px;">
    <h5 class="fw-bold mb-3">Nouveau projet d'investissement public</h5>

    <form method="POST" action="{{ route('projets.store') }}">
        @csrf

        @include('projets.form')

        <div class="d-flex justify-content-center gap-3 mt-4">
            <button type="submit" class="btn btn-brand">
                Enregistrer
            </button>

            <a href="{{ route('projets.index') }}" class="btn btn-outline-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
