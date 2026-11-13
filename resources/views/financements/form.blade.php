<ul class="nav nav-pills form-tabs mb-4 gap-2 flex-wrap" id="onglets-formulaire" role="tablist">
    <li class="nav-item" role="presentation"><button class="nav-link active" id="tab-identification" data-bs-toggle="tab" data-bs-target="#onglet-identification" type="button" role="tab" aria-controls="onglet-identification" aria-selected="true"><i class="bi bi-card-text me-1"></i>Identification</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-source" data-bs-toggle="tab" data-bs-target="#onglet-source" type="button" role="tab" aria-controls="onglet-source" aria-selected="false"><i class="bi bi-bank me-1"></i>Source et convention</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-tranche" data-bs-toggle="tab" data-bs-target="#onglet-tranche" type="button" role="tab" aria-controls="onglet-tranche" aria-selected="false"><i class="bi bi-cash-stack me-1"></i>Détail de la tranche</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-observation" data-bs-toggle="tab" data-bs-target="#onglet-observation" type="button" role="tab" aria-controls="onglet-observation" aria-selected="false"><i class="bi bi-journal-text me-1"></i>Observation</button></li>
</ul>
<div id="alerte-onglet" class="alert alert-danger d-none" role="alert"></div>
<div class="tab-content form-tab-content">
<div class="tab-pane fade show active" id="onglet-identification" role="tabpanel" tabindex="0">
<h6 class="fw-bold mb-3">Identification du financement</h6>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Référence</label>
        <input type="text" name="reference" value="{{ old('reference', $financement->reference ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Montant financé (FCFA)</label>
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
<div class="mb-3">
    <label class="form-label">Bailleur</label>
    <select name="bailleur_id" class="form-select" required>
        <option value="">-- Choisir --</option>
        @foreach($bailleurs as $b)<option value="{{ $b->id }}" @selected(old('bailleur_id', $financement->bailleur_id ?? '') == $b->id)>{{ $b->nom }}</option>@endforeach
    </select>
</div>
</div>
<div class="tab-pane fade" id="onglet-source" role="tabpanel" tabindex="0">
<h6 class="fw-bold mb-3">Source de financement et convention</h6>
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
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Numéro de convention</label>
        <input type="text" name="numero_convention" value="{{ old('numero_convention', $financement->numero_convention ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Date de convention</label>
        <input type="date" name="date_convention" value="{{ old('date_convention', optional($financement->date_convention ?? null)->format('Y-m-d')) }}" class="form-control">
    </div>
</div>
</div>
<div class="tab-pane fade" id="onglet-tranche" role="tabpanel" tabindex="0">
<h6 class="fw-bold mb-3">Détail de la tranche de financement</h6>
<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Code du bailleur / guichet</label>
        <input type="text" name="code_guichet" value="{{ old('code_guichet', $financement->code_guichet ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Devise</label>
        <input type="text" name="devise" value="{{ old('devise', $financement->devise ?? '') }}" class="form-control" placeholder="ex : CFA(XOF)">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Taux de change</label>
        <input type="number" step="0.0001" min="0" name="taux_change" value="{{ old('taux_change', $financement->taux_change ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Montant en devise</label>
        <input type="number" step="0.01" min="0" name="montant_devise" value="{{ old('montant_devise', $financement->montant_devise ?? '') }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Ressources internes (FCFA)</label>
        <input type="number" step="0.01" min="0" name="ressources_internes" value="{{ old('ressources_internes', $financement->ressources_internes ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Ressources externes (FCFA)</label>
        <input type="number" step="0.01" min="0" name="ressources_externes" value="{{ old('ressources_externes', $financement->ressources_externes ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">État de la tranche</label>
        <input type="text" name="statut" value="{{ old('statut', $financement->statut ?? '') }}" class="form-control" placeholder="ex : Acquis, À rechercher">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Bénéficiaire</label>
        <input type="text" name="beneficiaire" value="{{ old('beneficiaire', $financement->beneficiaire ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Dont don (FCFA)</label>
        <input type="number" step="0.01" min="0" name="montant_don" value="{{ old('montant_don', $financement->montant_don ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Dont emprunt (FCFA)</label>
        <input type="number" step="0.01" min="0" name="montant_emprunt" value="{{ old('montant_emprunt', $financement->montant_emprunt ?? '') }}" class="form-control">
    </div>
</div>
</div>
<div class="tab-pane fade" id="onglet-observation" role="tabpanel" tabindex="0">
<h6 class="fw-bold mb-3">Observation</h6>
<div class="mb-3">
    <label class="form-label">Observation</label>
    <textarea name="observation" class="form-control" rows="4">{{ old('observation', $financement->observation ?? '') }}</textarea>
</div>
</div>
</div>
<div class="d-flex justify-content-between mt-3">
    <button type="button" class="btn btn-outline-secondary" id="onglet-precedent"><i class="bi bi-arrow-left me-1"></i>Précédent</button>
    <button type="button" class="btn btn-outline-warning" id="onglet-suivant">Suivant<i class="bi bi-arrow-right ms-1"></i></button>
</div>

@include('partials.formulaire_onglets')
