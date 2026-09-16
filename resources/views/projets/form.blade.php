<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Référence</label>
        <input type="text" name="reference" value="{{ old('reference', $projet->reference ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Code PIP</label>
        <input type="text" name="code_pip" value="{{ old('code_pip', $projet->code_pip ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Intitulé</label>
        <input type="text" name="intitule" value="{{ old('intitule', $projet->intitule ?? '') }}" class="form-control" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Contexte</label>
    <textarea name="contexte" class="form-control" rows="2">{{ old('contexte', $projet->contexte ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Objectif</label>
    <textarea name="objectif" class="form-control" rows="2">{{ old('objectif', $projet->objectif ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Coût estimatif (FCFA)</label>
        <input type="number" step="0.01" name="cout_estimatif" value="{{ old('cout_estimatif', $projet->cout_estimatif ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Date début</label>
        <input type="date" name="date_debut" value="{{ old('date_debut', optional($projet->date_debut ?? null)->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Date fin</label>
        <input type="date" name="date_fin" value="{{ old('date_fin', optional($projet->date_fin ?? null)->format('Y-m-d')) }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Avancement physique (%)</label>
        <input type="number" min="0" max="100" name="avancement_physique" value="{{ old('avancement_physique', $projet->avancement_physique ?? 0) }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select" required>
            @foreach(['planifie'=>'Planifié','en_cours'=>'En cours','termine'=>'Terminé','suspendu'=>'Suspendu','retarde'=>'Retardé'] as $val=>$label)
                <option value="{{ $val }}" @selected(old('statut', $projet->statut ?? 'planifie') == $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Structure responsable</label>
        <select name="structure_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($structures as $s)<option value="{{ $s->id }}" @selected(old('structure_id', $projet->structure_id ?? '') == $s->id)>{{ $s->libelle }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Secteur</label>
        <select name="secteur_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($secteurs as $s)<option value="{{ $s->id }}" @selected(old('secteur_id', $projet->secteur_id ?? '') == $s->id)>{{ $s->libelle }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Zone de localisation</label>
        <select name="zone_localisation_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($zones as $z)<option value="{{ $z->id }}" @selected(old('zone_localisation_id', $projet->zone_localisation_id ?? '') == $z->id)>{{ str_replace('_',' ',$z->type) }} — {{ $z->libelle }}</option>@endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Axe (feuille de route)</label>
        <select name="axe_id" class="form-select">
            <option value="">-- Aucun --</option>
            @foreach($axes as $a)<option value="{{ $a->id }}" @selected(old('axe_id', $projet->axe_id ?? '') == $a->id)>{{ $a->libelle }} ({{ $a->programme->nom ?? '' }})</option>@endforeach
        </select>
    </div>
</div>

<hr>
<h6 class="fw-bold mb-3">Maîtrise d'ouvrage et d'œuvre</h6>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Maître d'ouvrage</label>
        <input type="text" name="maitre_ouvrage" value="{{ old('maitre_ouvrage', $projet->maitre_ouvrage ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Maître d'ouvrage délégué</label>
        <input type="text" name="maitre_ouvrage_delegue" value="{{ old('maitre_ouvrage_delegue', $projet->maitre_ouvrage_delegue ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Maître d'œuvre</label>
        <input type="text" name="maitre_oeuvre" value="{{ old('maitre_oeuvre', $projet->maitre_oeuvre ?? '') }}" class="form-control">
    </div>
</div>

<h6 class="fw-bold mb-3">Classification</h6>
<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Durée prévue</label>
        <input type="text" name="duree_prevue" value="{{ old('duree_prevue', $projet->duree_prevue ?? '') }}" class="form-control" placeholder="ex : 24 mois">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Type de projet</label>
        <select name="type_projet" class="form-select" required>
            <option value="investissement" @selected(old('type_projet', $projet->type_projet ?? 'investissement') == 'investissement')>Projet d'investissement</option>
            <option value="routine" @selected(old('type_projet', $projet->type_projet ?? '') == 'routine')>Routine</option>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Milieu d'exécution</label>
        <select name="milieu_execution" class="form-select">
            <option value="">-- Choisir --</option>
            <option value="rural" @selected(old('milieu_execution', $projet->milieu_execution ?? '') == 'rural')>Rural</option>
            <option value="urbain" @selected(old('milieu_execution', $projet->milieu_execution ?? '') == 'urbain')>Urbain</option>
            <option value="inter_urbain" @selected(old('milieu_execution', $projet->milieu_execution ?? '') == 'inter_urbain')>Inter-urbain</option>
            <option value="peri_urbain" @selected(old('milieu_execution', $projet->milieu_execution ?? '') == 'peri_urbain')>Péri-urbain</option>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">ODD concerné</label>
        <input type="text" name="odd_concerne" value="{{ old('odd_concerne', $projet->odd_concerne ?? '') }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Action PND</label>
        <input type="text" name="action_pnd" value="{{ old('action_pnd', $projet->action_pnd ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Programme budgétaire</label>
        <input type="text" name="programme_budgetaire" value="{{ old('programme_budgetaire', $projet->programme_budgetaire ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Domaine d'impact socio-économique</label>
        <input type="text" name="domaine_impact_socio_eco" value="{{ old('domaine_impact_socio_eco', $projet->domaine_impact_socio_eco ?? '') }}" class="form-control">
    </div>
</div>

<h6 class="fw-bold mb-3">Cibles trimestrielles</h6>
<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Trimestre 1</label>
        <input type="text" name="cible_trimestre_1" value="{{ old('cible_trimestre_1', $projet->cible_trimestre_1 ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Trimestre 2</label>
        <input type="text" name="cible_trimestre_2" value="{{ old('cible_trimestre_2', $projet->cible_trimestre_2 ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Trimestre 3</label>
        <input type="text" name="cible_trimestre_3" value="{{ old('cible_trimestre_3', $projet->cible_trimestre_3 ?? '') }}" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Trimestre 4</label>
        <input type="text" name="cible_trimestre_4" value="{{ old('cible_trimestre_4', $projet->cible_trimestre_4 ?? '') }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Code PJGouv</label>
        <input type="text" name="code_pjgouv" value="{{ old('code_pjgouv', $projet->code_pjgouv ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Code PSGouv</label>
        <input type="text" name="code_psgouv" value="{{ old('code_psgouv', $projet->code_psgouv ?? '') }}" class="form-control">
    </div>
</div>

<h6 class="fw-bold mb-3">Contexte, attentes et contraintes</h6>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Appartenance</label>
        <input type="text" name="appartenance" value="{{ old('appartenance', $projet->appartenance ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Taille</label>
        <input type="text" name="taille" value="{{ old('taille', $projet->taille ?? '') }}" class="form-control">
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Problème</label>
    <textarea name="probleme" class="form-control" rows="2">{{ old('probleme', $projet->probleme ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Attentes par rapport au projet</label>
    <textarea name="attentes_projet" class="form-control" rows="2">{{ old('attentes_projet', $projet->attentes_projet ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Craintes par rapport au projet</label>
    <textarea name="craintes_projet" class="form-control" rows="2">{{ old('craintes_projet', $projet->craintes_projet ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Observations</label>
    <textarea name="observations" class="form-control" rows="2">{{ old('observations', $projet->observations ?? '') }}</textarea>
</div>
<hr>
<div class="mb-3">
    <label class="form-label">Fiches PIP associées</label>
    <select name="fiches_pip[]" class="form-select" multiple size="4">
        @php $selectedFiches = old('fiches_pip', isset($projet) ? $projet->fichesPip->pluck('id')->toArray() : []); @endphp
        @foreach($fichesPip as $f)
            <option value="{{ $f->id }}" @selected(in_array($f->id, $selectedFiches))>{{ $f->numero }} — {{ $f->nom }}</option>
        @endforeach
    </select>
</div>
