<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Libellé <span class="text-danger">*</span></label>
        <input type="text" name="libelle" value="{{ old('libelle', $secteur->libelle ?? '') }}" class="form-control @error('libelle') is-invalid @enderror" required>
        @error('libelle') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description', $secteur->description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="statut" value="1" id="statut" {{ old('statut', $secteur->statut ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="statut">Secteur actif</label>
        </div>
    </div>
    <div class="col-12 d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Enregistrer</button>
        <a href="{{ route('secteurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</div>
