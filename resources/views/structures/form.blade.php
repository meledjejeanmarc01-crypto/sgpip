<div class="mb-3">
    <label class="form-label">Libellé</label>
    <input type="text" name="libelle" value="{{ old('libelle', $structure->libelle ?? '') }}" class="form-control" required>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Sigle</label>
        <input type="text" name="sigle" value="{{ old('sigle', $structure->sigle ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Type de structure</label>
        <select name="type_structure_id" class="form-select" required data-creer-url="{{ route('types-structure.store') }}" data-creer-nom="Nom du nouveau type de structure">
            <option value="">-- Choisir --</option>
            @foreach($types as $t)
                <option value="{{ $t->id }}" @selected(old('type_structure_id', $structure->type_structure_id ?? '') == $t->id)>{{ $t->libelle }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Adresse</label>
    <input type="text" name="adresse" value="{{ old('adresse', $structure->adresse ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label class="form-label">Téléphone</label>
    <input type="text" name="telephone" value="{{ old('telephone', $structure->telephone ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label class="form-label">E-mail (notification des décisions sur les projets)</label>
    <input type="email" name="email" value="{{ old('email', $structure->email ?? '') }}" class="form-control">
</div>
