@php
    $niveauInitial = old('niveau_id', isset($zone) ? $zone->localisation?->niveau_id : null);
@endphp
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Libellé</label>
        <input type="text" name="libelle" value="{{ old('libelle', $zone->libelle ?? '') }}" class="form-control" required>
        @error('libelle')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Pays</label>
        <input type="text" name="pays" value="{{ old('pays', $zone->pays ?? "Côte d'Ivoire") }}" class="form-control">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Niveau</label>
        <select name="niveau_id" id="zone-niveau" class="form-select">
            <option value="">-- Niveau --</option>
            @foreach($niveaux as $n)
                <option value="{{ $n->id }}" @selected($niveauInitial == $n->id)>{{ $n->libelle }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-8 mb-3">
        <label class="form-label">Localisation</label>
        <select name="localisation_id" id="zone-localisation" class="form-select"
                data-selected="{{ old('localisation_id', $zone->localisation_id ?? '') }}"
                data-zone="{{ $zone->id ?? '' }}">
            <option value="">-- Choisir un niveau d'abord --</option>
        </select>
        @error('localisation_id')<div class="text-danger small">{{ $message }}</div>@enderror
        <div class="form-text">Laisser vide uniquement pour une zone hors Côte d'Ivoire (choisir alors le pays étranger ci-dessous).</div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Pays étranger (si zone "Hors CI")</label>
    <select name="pays_etranger_id" class="form-select">
        <option value="">-- Aucun (zone en Côte d'Ivoire) --</option>
        @foreach($paysEtrangers as $p)
            <option value="{{ $p->id }}" @selected(old('pays_etranger_id', $zone->pays_etranger_id ?? '') == $p->id)>{{ $p->libelle }}</option>
        @endforeach
    </select>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select" required>
            @foreach(['actif' => 'Actif', 'inactif' => 'Inactif'] as $valeur => $texte)
                <option value="{{ $valeur }}" @selected(old('statut', $zone->statut ?? 'actif') === $valeur)>{{ $texte }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="2">{{ old('description', $zone->description ?? '') }}</textarea>
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

@push('scripts')
<script>
(function () {
    const niveau = document.getElementById('zone-niveau');
    const loc = document.getElementById('zone-localisation');
    const base = @json(url('/localisation/niveaux'));

    async function charger() {
        loc.innerHTML = '';
        if (!niveau.value) {
            loc.add(new Option("-- Choisir un niveau d'abord --", ''));
            return;
        }
        const url = `${base}/${niveau.value}/localisations?libres=1&except_zone=${loc.dataset.zone || ''}`;
        const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
        const liste = await res.json();
        loc.add(new Option('-- Sélectionner --', ''));
        liste.forEach(l => {
            const option = new Option(l.label, l.id);
            if (String(l.id) === String(loc.dataset.selected)) option.selected = true;
            loc.add(option);
        });
    }

    niveau.addEventListener('change', () => { loc.dataset.selected = ''; charger(); });
    charger();
})();
</script>
@endpush
