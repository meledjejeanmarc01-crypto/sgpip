<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Référence</label>
        <input type="text" name="reference" value="{{ old('reference', $decaissement->reference ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Montant (FCFA)</label>
        <input type="number" step="0.01" name="montant" value="{{ old('montant', $decaissement->montant ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="date" value="{{ old('date', optional($decaissement->date ?? null)->format('Y-m-d')) }}" class="form-control" required>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Bailleur</label>
        <select name="bailleur_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($bailleurs as $b)<option value="{{ $b->id }}" @selected(old('bailleur_id', $decaissement->bailleur_id ?? '') == $b->id)>{{ $b->nom }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Financement rattaché</label>
        <select name="financement_id" class="form-select">
            <option value="">-- Aucun --</option>
            @foreach($financements as $f)<option value="{{ $f->id }}" @selected(old('financement_id', $decaissement->financement_id ?? '') == $f->id)>{{ $f->reference }} — {{ $f->projet->intitule ?? '' }}</option>@endforeach
        </select>
    </div>
</div>
