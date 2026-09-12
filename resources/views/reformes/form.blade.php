<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Libellé</label>
        <input type="text" name="libelle" value="{{ old('libelle', $reforme->libelle ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select" required>
            <option value="demarree" @selected(old('statut', $reforme->statut ?? '') == 'demarree')>Démarrée</option>
            <option value="en_cours" @selected(old('statut', $reforme->statut ?? '') == 'en_cours')>En cours</option>
            <option value="achevee" @selected(old('statut', $reforme->statut ?? '') == 'achevee')>Achevée</option>
        </select>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Résultat global attendu</label>
    <textarea name="resultat_global_attendu" class="form-control" rows="2">{{ old('resultat_global_attendu', $reforme->resultat_global_attendu ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Structure pilote</label>
        <select name="structure_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($structures as $s)
                <option value="{{ $s->id }}" @selected(old('structure_id', $reforme->structure_id ?? '') == $s->id)>{{ $s->libelle }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Axe</label>
        <select name="axe_id" class="form-select">
            <option value="">-- Aucun --</option>
            @foreach($axes as $a)
                <option value="{{ $a->id }}" @selected(old('axe_id', $reforme->axe_id ?? '') == $a->id)>{{ $a->libelle }} ({{ $a->programme->nom ?? '' }})</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Année début</label>
        <input type="number" min="2000" max="2100" name="annee_debut" value="{{ old('annee_debut', $reforme->annee_debut ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Année fin</label>
        <input type="number" min="2000" max="2100" name="annee_fin" value="{{ old('annee_fin', $reforme->annee_fin ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Date de transmission au SGG</label>
        <input type="date" name="date_transmission_sgg" value="{{ old('date_transmission_sgg', optional($reforme->date_transmission_sgg ?? null)->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Localité</label>
        <input type="text" name="localite" value="{{ old('localite', $reforme->localite ?? '') }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Taux d'exécution année précédente (%)</label>
        <input type="number" step="0.01" min="0" max="100" name="taux_execution_annee_precedente" value="{{ old('taux_execution_annee_precedente', $reforme->taux_execution_annee_precedente ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Taux d'exécution prévisionnel année en cours (%)</label>
        <input type="number" step="0.01" min="0" max="100" name="taux_execution_previsionnel" value="{{ old('taux_execution_previsionnel', $reforme->taux_execution_previsionnel ?? '') }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Cible trimestre 1</label>
        <input type="text" name="cible_trimestre_1" value="{{ old('cible_trimestre_1', $reforme->cible_trimestre_1 ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Cible trimestre 2</label>
        <input type="text" name="cible_trimestre_2" value="{{ old('cible_trimestre_2', $reforme->cible_trimestre_2 ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Cible trimestre 3</label>
        <input type="text" name="cible_trimestre_3" value="{{ old('cible_trimestre_3', $reforme->cible_trimestre_3 ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Cible trimestre 4</label>
        <input type="text" name="cible_trimestre_4" value="{{ old('cible_trimestre_4', $reforme->cible_trimestre_4 ?? '') }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Budget global</label>
        <input type="number" step="0.01" min="0" name="budget_global" value="{{ old('budget_global', $reforme->budget_global ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Source de financement</label>
        <input type="text" name="source_financement" value="{{ old('source_financement', $reforme->source_financement ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Montant État</label>
        <input type="number" step="0.01" min="0" name="montant_etat" value="{{ old('montant_etat', $reforme->montant_etat ?? '') }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Montant autres bailleurs</label>
        <input type="number" step="0.01" min="0" name="montant_autres_bailleurs" value="{{ old('montant_autres_bailleurs', $reforme->montant_autres_bailleurs ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Code PJGouv</label>
        <input type="text" name="code_pjgouv" value="{{ old('code_pjgouv', $reforme->code_pjgouv ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Code PSGouv</label>
        <input type="text" name="code_psgouv" value="{{ old('code_psgouv', $reforme->code_psgouv ?? '') }}" class="form-control">
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Livrables attendus</label>
    <textarea name="livrables_attendus" class="form-control" rows="2">{{ old('livrables_attendus', $reforme->livrables_attendus ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Indicateurs</label>
    <textarea name="indicateurs" class="form-control" rows="2">{{ old('indicateurs', $reforme->indicateurs ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Observations</label>
    <textarea name="observations" class="form-control" rows="2">{{ old('observations', $reforme->observations ?? '') }}</textarea>
</div>
