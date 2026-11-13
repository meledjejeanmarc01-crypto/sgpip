@extends('layouts.app')
@section('page-title', 'Nouveau pays étranger')
@section('content')
<div class="card card-stat p-4" style="max-width:500px;">
    <h5 class="fw-bold mb-3">Nouveau pays étranger</h5>
    <form method="POST" action="{{ route('pays-etrangers.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Code ISO</label>
            <input type="text" name="code_iso" value="{{ old('code_iso') }}" class="form-control" maxlength="3" placeholder="ex : FR">
        </div>
        <button class="btn btn-brand">Enregistrer</button>
        <a href="{{ route('pays-etrangers.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
