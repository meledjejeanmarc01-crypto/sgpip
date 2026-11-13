<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $bailleur->nom ?? '') }}" class="form-control" required>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Sigle</label>
        <input type="text" name="sigle" value="{{ old('sigle', $bailleur->sigle ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Type de bailleur</label>
        <div class="input-group">
            <select name="type_bailleur_id" id="type_bailleur_id" class="form-select" required>
                <option value="">-- Choisir --</option>
                @foreach($types as $t)
                    <option value="{{ $t->id }}" @selected(old('type_bailleur_id', $bailleur->type_bailleur_id ?? '') == $t->id)>{{ $t->libelle }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#nouveauTypeBailleurModal" title="Créer un nouveau type de bailleur">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="nouveauTypeBailleurModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Nouveau type de bailleur</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Libellé</label>
                <input type="text" id="nouveau_type_libelle" class="form-control" placeholder="ex : Bailleur bilatéral">
                <div id="nouveauTypeBailleurError" class="text-danger small mt-1"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="btnCreerTypeBailleur" class="btn btn-brand">Créer</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('btnCreerTypeBailleur').addEventListener('click', function () {
    const libelle = document.getElementById('nouveau_type_libelle').value.trim();
    const errorBox = document.getElementById('nouveauTypeBailleurError');
    errorBox.textContent = '';
    if (!libelle) {
        errorBox.textContent = 'Le libellé est requis.';
        return;
    }
    fetch('{{ route('types-bailleur.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ libelle: libelle }),
    })
    .then(async (res) => {
        const data = await res.json();
        if (!res.ok) {
            const message = data.errors ? Object.values(data.errors)[0][0] : "Une erreur est survenue.";
            throw new Error(message);
        }
        return data;
    })
    .then((data) => {
        const select = document.getElementById('type_bailleur_id');
        const option = document.createElement('option');
        option.value = data.id;
        option.textContent = data.libelle;
        option.selected = true;
        select.appendChild(option);
        document.getElementById('nouveau_type_libelle').value = '';
        bootstrap.Modal.getInstance(document.getElementById('nouveauTypeBailleurModal')).hide();
    })
    .catch((err) => {
        errorBox.textContent = err.message;
    });
});
</script>
@endpush
<div class="mb-3">
    <label class="form-label">Pays du bailleur</label>
    <select name="pays_etranger_id" class="form-select">
        <option value="">-- Aucun / Côte d'Ivoire --</option>
        @foreach($pays as $p)
            <option value="{{ $p->id }}" @selected(old('pays_etranger_id', $bailleur->pays_etranger_id ?? '') == $p->id)>{{ $p->libelle }}@if($p->code_iso) ({{ strtoupper($p->code_iso) }})@endif</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Contact</label>
    <input type="text" name="contact" value="{{ old('contact', $bailleur->contact ?? '') }}" class="form-control">
</div>
