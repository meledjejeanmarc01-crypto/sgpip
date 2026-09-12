<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Libellé</label>
        <input type="text" name="libelle" value="{{ old('libelle', $depense->libelle ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Référence</label>
        <input type="text" name="reference" value="{{ old('reference', $depense->reference ?? '') }}" class="form-control" required>
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Montant (FCFA)</label>
        <input type="number" step="0.01" name="montant" value="{{ old('montant', $depense->montant ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="date" value="{{ old('date', optional($depense->date ?? null)->format('Y-m-d')) }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Projet (optionnel)</label>
        <select name="projet_id" class="form-select">
            <option value="">-- Aucun --</option>
            @foreach($projets as $p)<option value="{{ $p->id }}" @selected(old('projet_id', $depense->projet_id ?? '') == $p->id)>{{ $p->intitule }}</option>@endforeach
        </select>
    </div>
</div>
