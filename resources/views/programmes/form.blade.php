<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Code</label>
        <input type="text" name="code" value="{{ old('code', $programme->code ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-8 mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" value="{{ old('nom', $programme->nom ?? '') }}" class="form-control" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Libellé (description courte)</label>
    <input type="text" name="libelle" value="{{ old('libelle', $programme->libelle ?? '') }}" class="form-control">
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Date début</label>
        <input type="date" name="date_debut" value="{{ old('date_debut', optional($programme->date_debut ?? null)->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Date fin</label>
        <input type="date" name="date_fin" value="{{ old('date_fin', optional($programme->date_fin ?? null)->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Structure pilote</label>
        <select name="structure_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($structures as $s)
                <option value="{{ $s->id }}" @selected(old('structure_id', $programme->structure_id ?? '') == $s->id)>{{ $s->libelle }}</option>
            @endforeach
        </select>
    </div>
</div>
