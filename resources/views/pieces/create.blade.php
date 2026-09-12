@extends('layouts.app')
@section('page-title', 'Nouvelle pièce justificative')
@section('content')
<div class="card card-stat p-4" style="max-width:650px;">
    <h5 class="fw-bold mb-3">Ajouter une pièce justificative</h5>
    <form method="POST" action="{{ route('pieces-justificatives.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Catégorie</label>
                <select name="categorie" class="form-select" required>
                    @foreach(['facture'=>'Facture','recu'=>'Reçu','contrat'=>'Contrat','proces_verbal'=>'Procès-verbal','autre'=>'Autre'] as $val=>$label)
                        <option value="{{ $val }}" @selected(old('categorie')==$val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Projet</label>
                <select name="projet_id" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    @foreach($projets as $p)
                        <option value="{{ $p->id }}" @selected(old('projet_id', request('projet_id')) == $p->id)>{{ $p->intitule }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Fichier (PDF, DOC, DOCX, XLS, XLSX)</label>
            <input type="file" name="fichier" class="form-control" required>
        </div>
        <button class="btn text-white" style="background:#FF8200;">Enregistrer</button>
        <a href="{{ route('pieces-justificatives.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>
@endsection
