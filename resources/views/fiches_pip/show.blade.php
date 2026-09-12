@extends('layouts.app')
@section('page-title', 'Détail de la fiche PIP')
@section('content')
<div class="card card-stat p-4 mb-3">
    <h5 class="fw-bold">{{ $fiche->nom }} <span class="text-muted">({{ $fiche->numero }})</span></h5>
    <p class="text-muted mb-0">Programme : <a href="{{ route('programmes.show', $fiche->programme) }}">{{ $fiche->programme->nom ?? '—' }}</a></p>
</div>
<div class="card card-stat p-3">
    <h6 class="fw-bold mb-3">Associer des projets à cette fiche</h6>
    <form method="POST" action="{{ route('fiches-pip.associer', $fiche) }}">
        @csrf
        <div class="mb-3">
            <select name="projets[]" class="form-select" multiple size="6">
                @foreach(\App\Models\Projet::orderBy('intitule')->get() as $p)
                    <option value="{{ $p->id }}" @selected($fiche->projets->contains($p->id))>{{ $p->reference }} — {{ $p->intitule }}</option>
                @endforeach
            </select>
            <div class="form-text">Maintenez Ctrl (ou Cmd) enfoncé pour sélectionner plusieurs projets.</div>
        </div>
        <button class="btn btn-sm text-white" style="background:#FF8200;">Mettre à jour les associations</button>
    </form>
</div>
@endsection
