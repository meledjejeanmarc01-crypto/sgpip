<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Titre</label>
        <input type="text" name="titre" value="{{ old('titre', $rapport->titre ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Type</label>
        <select name="type" class="form-select" required>
            @foreach(['avancement'=>'Avancement','financier'=>'Financier','physique'=>'Physique','suivi'=>'Suivi','annuel'=>'Annuel','trimestriel'=>'Trimestriel','mensuel'=>'Mensuel','synthese'=>'Synthèse','execution'=>'Exécution'] as $val=>$label)
                <option value="{{ $val }}" @selected(old('type', $rapport->type ?? '') == $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="date" value="{{ old('date', optional($rapport->date ?? null)->format('Y-m-d')) }}" class="form-control" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Projet</label>
    <select name="projet_id" class="form-select" required>
        <option value="">-- Choisir --</option>
        @foreach($projets as $p)
            <option value="{{ $p->id }}" @selected(old('projet_id', $rapport->projet_id ?? request('projet_id')) == $p->id)>{{ $p->reference }} — {{ $p->intitule }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Contenu / observations</label>
    <textarea name="donnees" class="form-control" rows="4">{{ old('donnees', $rapport->donnees ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Fichier joint (PDF, DOC, DOCX, XLS, XLSX)</label>
    <input type="file" name="fichier" class="form-control">
    @isset($rapport->fichier)
        @if($rapport->fichier)<div class="form-text">Fichier actuel : {{ basename($rapport->fichier) }}</div>@endif
    @endisset
</div>
