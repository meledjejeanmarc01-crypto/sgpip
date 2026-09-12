<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Numéro</label>
        <input type="text" name="numero" value="{{ old('numero', $fiche->numero ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-8 mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" value="{{ old('nom', $fiche->nom ?? '') }}" class="form-control" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Programme</label>
    <select name="programme_id" class="form-select" required>
        <option value="">-- Choisir --</option>
        @foreach($programmes as $p)
            <option value="{{ $p->id }}" @selected(old('programme_id', $fiche->programme_id ?? '') == $p->id)>{{ $p->nom }} ({{ $p->code }})</option>
        @endforeach
    </select>
</div>
