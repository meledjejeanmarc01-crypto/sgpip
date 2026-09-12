<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Sigle</label>
        <input type="text" name="sigle" value="{{ old('sigle', $etat->sigle ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-8 mb-3">
        <label class="form-label">Libellé</label>
        <input type="text" name="libelle" value="{{ old('libelle', $etat->libelle ?? '') }}" class="form-control" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Adresse</label>
    <input type="text" name="adresse" value="{{ old('adresse', $etat->adresse ?? '') }}" class="form-control">
</div>
