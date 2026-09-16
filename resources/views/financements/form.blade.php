@php
    $isBailleur = old('source_type', $financement->bailleur_id ?? null ? 'bailleur' : ($financement->etat_id ?? null ? 'etat' : 'bailleur')) == 'bailleur';
@endphp
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Référence</label>
        <input type="text" name="reference" value="{{ old('reference', $financement->reference ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Montant engagé (FCFA)</label>
        <input type="number" step="0.01" name="montant_engage" value="{{ old('montant_engage', $financement->montant_engage ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="date" value="{{ old('date', optional($financement->date ?? null)->format('Y-m-d')) }}" class="form-control" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Projet</label>
    <select name="projet_id" class="form-select" required>
        <option value="">-- Choisir --</option>
        @foreach($projets as $p)<option value="{{ $p->id }}" @selected(old('projet_id', $financement->projet_id ?? '') == $p->id)>{{ $p->reference }} — {{ $p->intitule }}</option>@endforeach
    </select>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Source du financement</label>
        <select name="source_type" id="source_type" class="form-select" onchange="toggleSource()">
            <option value="bailleur" @selected($isBailleur)>Bailleur</option>
            <option value="etat" @selected(!$isBailleur)>État (institutionnel)</option>
        </select>
    </div>
    <div class="col-md-4 mb-3" id="bailleur-field">
        <label class="form-label">Bailleur</label>
        <select name="bailleur_id" class="form-select">
            <option value="">-- Choisir --</option>
            @foreach($bailleurs as $b)<option value="{{ $b->id }}" @selected(old('bailleur_id', $financement->bailleur_id ?? '') == $b->id)>{{ $b->nom }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3" id="etat-field">
        <label class="form-label">État</label>
        <select name="etat_id" class="form-select">
            <option value="">-- Choisir --</option>
            @foreach($etats as $e)<option value="{{ $e->id }}" @selected(old('etat_id', $financement->etat_id ?? '') == $e->id)>{{ $e->libelle }}</option>@endforeach
        </select>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Nature de la source de financement</label>
    <select name="type_source" class="form-select">
        <option value="">-- Non précisé --</option>
        <option value="tresor" @selected(old('type_source', $financement->type_source ?? '') == 'tresor')>Trésor</option>
        <option value="emprunt" @selected(old('type_source', $financement->type_source ?? '') == 'emprunt')>Emprunt</option>
        <option value="don" @selected(old('type_source', $financement->type_source ?? '') == 'don')>Don</option>
        <option value="participation_collectivites" @selected(old('type_source', $financement->type_source ?? '') == 'participation_collectivites')>Participation des collectivités</option>
        <option value="participation_populations" @selected(old('type_source', $financement->type_source ?? '') == 'participation_populations')>Participation des populations</option>
        <option value="participation_secteur_prive" @selected(old('type_source', $financement->type_source ?? '') == 'participation_secteur_prive')>Participation du secteur privé</option>
        <option value="ppp" @selected(old('type_source', $financement->type_source ?? '') == 'ppp')>Partenariat Public-Privé (PPP)</option>
        <option value="fonds_propres_parapublics" @selected(old('type_source', $financement->type_source ?? '') == 'fonds_propres_parapublics')>Fonds propres parapublics</option>
    </select>
</div>
<script>
function toggleSource(){
    const v = document.getElementById('source_type').value;
    document.getElementById('bailleur-field').style.display = v === 'bailleur' ? 'block' : 'none';
    document.getElementById('etat-field').style.display = v === 'etat' ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', toggleSource);
</script>
