<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Type de zone</label>
        <select name="type" class="form-select" required>
            @foreach(['district'=>'District','region'=>'Région','departement'=>'Département','sous_prefecture'=>'Sous-préfecture','commune'=>'Commune','localite'=>'Localité'] as $val => $label)
                <option value="{{ $val }}" @selected(old('type', $zone->type ?? '') == $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Libellé</label>
        <input type="text" name="libelle" value="{{ old('libelle', $zone->libelle ?? '') }}" class="form-control" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Zone parente (niveau supérieur)</label>
    <select name="parent_id" class="form-select">
        <option value="">-- Aucune (niveau racine) --</option>
        @foreach($parents as $p)
            <option value="{{ $p->id }}" @selected(old('parent_id', $zone->parent_id ?? '') == $p->id)>{{ str_replace('_',' ',$p->type) }} — {{ $p->libelle }}</option>
        @endforeach
    </select>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Latitude</label>
        <input type="number" step="0.000001" name="latitude" value="{{ old('latitude', $zone->latitude ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Longitude</label>
        <input type="number" step="0.000001" name="longitude" value="{{ old('longitude', $zone->longitude ?? '') }}" class="form-control">
    </div>
</div>
