<style>
    .form-tabs .nav-link { border: 1px solid #dee2e6; background: #fff; color: #495057; border-radius: 2rem; padding: .4rem 1.1rem; font-weight: 500; transition: all .15s ease; }
    .form-tabs .nav-link:hover { border-color: #FF8200; color: #E06E00; }
    .form-tabs .nav-link.active { background: #FF8200; border-color: #FF8200; color: #fff; box-shadow: 0 2px 8px rgba(255,130,0,.3); }
    .form-tabs .nav-link.text-danger:not(.active) { border-color: #dc3545; }
    .form-tab-content { background: #fff; border: 1px solid #eef0f3; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 1px 4px rgba(0,0,0,.04); }
    .form-tab-content h6 { color: #E06E00; border-bottom: 2px solid #FFE3C7; padding-bottom: .4rem; }
</style>
<ul class="nav nav-pills form-tabs mb-4 gap-2 flex-wrap" id="onglets-projet" role="tablist">
    <li class="nav-item" role="presentation"><button class="nav-link active" id="tab-identification" data-bs-toggle="tab" data-bs-target="#onglet-identification" type="button" role="tab" aria-controls="onglet-identification" aria-selected="true"><i class="bi bi-card-text me-1"></i>Identification</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-planification" data-bs-toggle="tab" data-bs-target="#onglet-planification" type="button" role="tab" aria-controls="onglet-planification" aria-selected="false"><i class="bi bi-calendar-check me-1"></i>Planification</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-rattachement" data-bs-toggle="tab" data-bs-target="#onglet-rattachement" type="button" role="tab" aria-controls="onglet-rattachement" aria-selected="false"><i class="bi bi-diagram-3 me-1"></i>Rattachement</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-maitrise" data-bs-toggle="tab" data-bs-target="#onglet-maitrise" type="button" role="tab" aria-controls="onglet-maitrise" aria-selected="false"><i class="bi bi-building me-1"></i>Maîtrise d'ouvrage</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-responsables" data-bs-toggle="tab" data-bs-target="#onglet-responsables" type="button" role="tab" aria-controls="onglet-responsables" aria-selected="false"><i class="bi bi-people me-1"></i>Responsables</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-perimetre" data-bs-toggle="tab" data-bs-target="#onglet-perimetre" type="button" role="tab" aria-controls="onglet-perimetre" aria-selected="false"><i class="bi bi-bounding-box me-1"></i>Périmètre</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-ancrage" data-bs-toggle="tab" data-bs-target="#onglet-ancrage" type="button" role="tab" aria-controls="onglet-ancrage" aria-selected="false"><i class="bi bi-compass me-1"></i>Ancrage stratégique</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-localisation" data-bs-toggle="tab" data-bs-target="#onglet-localisation" type="button" role="tab" aria-controls="onglet-localisation" aria-selected="false"><i class="bi bi-geo-alt me-1"></i>Localisation</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-cibles" data-bs-toggle="tab" data-bs-target="#onglet-cibles" type="button" role="tab" aria-controls="onglet-cibles" aria-selected="false"><i class="bi bi-bullseye me-1"></i>Cibles et codes</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link" id="tab-contexte" data-bs-toggle="tab" data-bs-target="#onglet-contexte" type="button" role="tab" aria-controls="onglet-contexte" aria-selected="false"><i class="bi bi-chat-left-text me-1"></i>Contexte</button></li>
</ul>
<div id="alerte-onglet" class="alert alert-danger d-none" role="alert"></div>
<div class="tab-content form-tab-content">
<div class="tab-pane fade show active" id="onglet-identification" role="tabpanel" tabindex="0">
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
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Date d'identification de l'idée projet</label>
        <input type="date" name="date_identification" value="{{ old('date_identification', optional($projet->date_identification ?? null)->format('Y-m-d')) }}" class="form-control">
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Contexte</label>
    <textarea name="contexte" class="form-control" rows="2">{{ old('contexte', $projet->contexte ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Objectif global</label>
    <textarea name="objectif" class="form-control" rows="2">{{ old('objectif', $projet->objectif ?? '') }}</textarea>
</div>
</div>
<div class="tab-pane fade" id="onglet-planification" role="tabpanel" tabindex="0">
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
</div>
<div class="tab-pane fade" id="onglet-rattachement" role="tabpanel" tabindex="0">
<div class="row">
    <div class="col-md-6">
        @include('projets.partials.champ_autocomplete', ['nom' => 'structure_id', 'label' => 'Structure responsable', 'type' => 'structure',
            'items' => $structures->map(fn ($x) => ['id' => $x->id, 'libelle' => $x->libelle, 'sigle' => $x->sigle])->values(),
            'selected' => old('structure_id', $projet->structure_id ?? '')])
    </div>
    <div class="col-md-6">
        @include('projets.partials.champ_autocomplete', ['nom' => 'secteur_id', 'label' => 'Secteur', 'type' => 'secteur',
            'items' => $secteurs->map(fn ($x) => ['id' => $x->id, 'libelle' => $x->libelle, 'sigle' => null])->values(),
            'selected' => old('secteur_id', $projet->secteur_id ?? '')])
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        {{-- RG17 : un projet est géré par un ou plusieurs utilisateurs. --}}
        @if(! isset($projet) || auth()->user()->isAdministrateur())
        <label class="form-label">Gestionnaire(s) du projet</label>
        @php
            $gestionnairesDispo = \App\Models\User::whereIn('role', ['administrateur', 'gestionnaire_projet'])->where('actif', true)->orderBy('nom')->get();
            $selectedGest = old('gestionnaires', isset($projet) ? $projet->gestionnaires->pluck('id')->toArray() : []);
        @endphp
        <select name="gestionnaires[]" class="form-select" multiple size="4">
            @foreach($gestionnairesDispo as $g)<option value="{{ $g->id }}" @selected(in_array($g->id, $selectedGest))>{{ $g->prenom }} {{ $g->nom }}</option>@endforeach
        </select>
        <div class="form-text">Ctrl/Cmd + clic pour en sélectionner plusieurs. À défaut, vous serez désigné gestionnaire.</div>
        @else
        <label class="form-label">Gestionnaire(s) du projet</label>
        <div class="form-control-plaintext">{{ $projet->gestionnaires->map(fn ($g) => $g->prenom.' '.$g->nom)->join(', ') ?: '—' }}</div>
        <div class="form-text">Seul l'administrateur peut modifier la liste des gestionnaires.</div>
        @endif
    </div>
    <div class="col-md-6">
        @include('projets.partials.champ_autocomplete', ['nom' => 'axe_id', 'label' => 'Axe (feuille de route)', 'type' => 'axe', 'obligatoire' => false,
            'items' => $axes->map(fn ($x) => ['id' => $x->id, 'libelle' => $x->libelle, 'sigle' => $x->programme->nom ?? null])->values(),
            'selected' => old('axe_id', $projet->axe_id ?? '')])
    </div>
</div>

</div>
<div class="tab-pane fade" id="onglet-maitrise" role="tabpanel" tabindex="0">
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
        <label class="form-label">Maître d'ouvrage associé</label>
        <input type="text" name="maitre_ouvrage_associe" value="{{ old('maitre_ouvrage_associe', $projet->maitre_ouvrage_associe ?? '') }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Maître d'œuvre</label>
        <input type="text" name="maitre_oeuvre" value="{{ old('maitre_oeuvre', $projet->maitre_oeuvre ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Maître d'œuvre délégué</label>
        <input type="text" name="maitre_oeuvre_delegue" value="{{ old('maitre_oeuvre_delegue', $projet->maitre_oeuvre_delegue ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Maître d'œuvre associé</label>
        <input type="text" name="maitre_oeuvre_associe" value="{{ old('maitre_oeuvre_associe', $projet->maitre_oeuvre_associe ?? '') }}" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Section budgétaire</label>
        <input type="text" name="section_budgetaire" value="{{ old('section_budgetaire', $projet->section_budgetaire ?? '') }}" class="form-control">
    </div>
</div>

</div>
<div class="tab-pane fade" id="onglet-responsables" role="tabpanel" tabindex="0">
<h6 class="fw-bold mb-3">Personnes ressources</h6>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="border rounded p-3 h-100">
            <div class="fw-semibold mb-2">Responsable du projet</div>
            <div class="mb-2">
                <label class="form-label small mb-0">Nom et prénoms</label>
                <input type="text" name="responsable_nom" value="{{ old('responsable_nom', $projet->responsable_nom ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Fonction</label>
                <input type="text" name="responsable_fonction" value="{{ old('responsable_fonction', $projet->responsable_fonction ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Téléphone</label>
                <input type="text" name="responsable_telephone" value="{{ old('responsable_telephone', $projet->responsable_telephone ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Cellulaire</label>
                <input type="text" name="responsable_cellulaire" value="{{ old('responsable_cellulaire', $projet->responsable_cellulaire ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">E-mail</label>
                <input type="email" name="responsable_email" value="{{ old('responsable_email', $projet->responsable_email ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Adresse géographique</label>
                <input type="text" name="responsable_adresse" value="{{ old('responsable_adresse', $projet->responsable_adresse ?? '') }}" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="border rounded p-3 h-100">
            <div class="fw-semibold mb-2">Rédacteur de la fiche</div>
            <div class="mb-2">
                <label class="form-label small mb-0">Nom et prénoms</label>
                <input type="text" name="redacteur_nom" value="{{ old('redacteur_nom', $projet->redacteur_nom ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Fonction</label>
                <input type="text" name="redacteur_fonction" value="{{ old('redacteur_fonction', $projet->redacteur_fonction ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Téléphone</label>
                <input type="text" name="redacteur_telephone" value="{{ old('redacteur_telephone', $projet->redacteur_telephone ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Cellulaire</label>
                <input type="text" name="redacteur_cellulaire" value="{{ old('redacteur_cellulaire', $projet->redacteur_cellulaire ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">E-mail</label>
                <input type="email" name="redacteur_email" value="{{ old('redacteur_email', $projet->redacteur_email ?? '') }}" class="form-control form-control-sm">
            </div>
            <div class="mb-2">
                <label class="form-label small mb-0">Adresse géographique</label>
                <input type="text" name="redacteur_adresse" value="{{ old('redacteur_adresse', $projet->redacteur_adresse ?? '') }}" class="form-control form-control-sm">
            </div>
        </div>
    </div>
</div>

</div>
<div class="tab-pane fade" id="onglet-perimetre" role="tabpanel" tabindex="0">
<h6 class="fw-bold mb-1">Périmètre : sections de compétence</h6>
<div class="form-text mb-2">Pour un projet multisectoriel : indiquer jusqu'à 5 sections (section 1 = section de la structure porteuse).</div>
@php $perimetre = old('perimetre_sections', isset($projet) ? ($projet->perimetre_sections ?? []) : []); @endphp
<div class="row">
@for($i = 0; $i < 5; $i++)
    <div class="col-md-6 mb-2">
        <label class="form-label small mb-0">Section {{ $i + 1 }}</label>
        <input type="text" name="perimetre_sections[]" value="{{ $perimetre[$i] ?? '' }}" class="form-control form-control-sm">
    </div>
@endfor
</div>

<h6 class="fw-bold mb-3 mt-3">Attributions du Ministère en lien avec le projet</h6>
<div class="mb-3">
    <textarea name="attributions_ministere" class="form-control" rows="4">{{ old('attributions_ministere', $projet->attributions_ministere ?? '') }}</textarea>
</div>

<h6 class="fw-bold mb-3">Classification</h6>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Durée prévue</label>
        <input type="text" name="duree_prevue" value="{{ old('duree_prevue', $projet->duree_prevue ?? '') }}" class="form-control" placeholder="ex : 24 mois">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Type de projet</label>
        <select name="type_projet" class="form-select" required>
            <option value="investissement" @selected(old('type_projet', $projet->type_projet ?? 'investissement') == 'investissement')>Projet d'investissement</option>
            <option value="routine" @selected(old('type_projet', $projet->type_projet ?? '') == 'routine')>Routine</option>
        </select>
    </div>
</div>

</div>
<div class="tab-pane fade" id="onglet-ancrage" role="tabpanel" tabindex="0">
<h6 class="fw-bold mb-3">Programme(s) et action(s) budgétaire</h6>
<div class="mb-3">
    <textarea name="programme_budgetaire" class="form-control" rows="2" placeholder="ex : Administration Générale">{{ old('programme_budgetaire', $projet->programme_budgetaire ?? '') }}</textarea>
</div>

<h6 class="fw-bold mb-3">Appartenance du projet au portefeuille projet/programme issu du PND</h6>
@php
    $pnd = old('appartient_portefeuille_pnd', isset($projet) ? $projet->appartient_portefeuille_pnd : null);
    $pndVal = is_null($pnd) ? null : (int) (bool) $pnd;
@endphp
<div class="mb-2">
    <span class="me-3">Projet issu du portefeuille projet/programme du PND ?</span>
    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="appartient_portefeuille_pnd" id="pnd-oui" value="1" @checked($pndVal === 1)><label class="form-check-label" for="pnd-oui">Oui</label></div>
    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="appartient_portefeuille_pnd" id="pnd-non" value="0" @checked($pndVal === 0)><label class="form-check-label" for="pnd-non">Non</label></div>
</div>
<div class="mb-3">
    <label class="form-label">Identifier le(s) projet(s)</label>
    <textarea name="portefeuille_pnd_projets" class="form-control" rows="2">{{ old('portefeuille_pnd_projets', $projet->portefeuille_pnd_projets ?? '') }}</textarea>
</div>

<h6 class="fw-bold mb-3">Arrimage au cadre de résultats du PND et domaine d'impact</h6>
<div class="row">
    <div class="col-md-6">
        @include('projets.partials.champ_autocomplete', ['nom' => 'action_pnd_id', 'label' => 'Action(s) PND', 'type' => 'action_pnd',
            'items' => $actionsPnd->map(fn ($x) => ['id' => $x->id, 'libelle' => $x->libelle, 'sigle' => null])->values(),
            'selected' => old('action_pnd_id', $projet->action_pnd_id ?? '')])
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Domaine d'impact socio-économique</label>
        <input type="text" name="domaine_impact_socio_eco" value="{{ old('domaine_impact_socio_eco', $projet->domaine_impact_socio_eco ?? '') }}" class="form-control">
    </div>
</div>

<h6 class="fw-bold mb-3">Ancrage au plan stratégique ou à la politique sectorielle</h6>
<div class="mb-3">
    <label class="form-label">Document de politique / stratégie (source)</label>
    <input type="text" name="ancrage_document_source" value="{{ old('ancrage_document_source', $projet->ancrage_document_source ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label class="form-label">Objectif(s) et/ou stratégie(s) concerné(s)</label>
    <textarea name="ancrage_objectifs_strategies" class="form-control" rows="3">{{ old('ancrage_objectifs_strategies', $projet->ancrage_objectifs_strategies ?? '') }}</textarea>
</div>

<h6 class="fw-bold mb-3">Objectifs de développement durable (ODD) concernés</h6>
<div class="mb-3">
    <textarea name="odd_concerne" class="form-control" rows="3" placeholder="ex : ODD 9 (Industrie, Innovation et Infrastructure)">{{ old('odd_concerne', $projet->odd_concerne ?? '') }}</textarea>
</div>

</div>
<div class="tab-pane fade" id="onglet-localisation" role="tabpanel" tabindex="0">
<h6 class="fw-bold mb-3">Milieu d'exécution</h6>
{{-- RG37 : un projet peut avoir plusieurs milieux d'exécution. --}}
@php $selectedMilieux = old('milieux_execution', isset($projet) ? $projet->milieuxExecution->pluck('categorie')->toArray() : []); @endphp
<div class="d-flex flex-wrap gap-4 mb-3">
    @foreach(['rural' => 'Rural', 'urbain' => 'Urbain', 'inter_urbain' => 'Inter-urbain', 'peri_urbain' => 'Péri-urbain'] as $val => $lib)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="milieux_execution[]" value="{{ $val }}" id="milieu-{{ $val }}" @checked(in_array($val, $selectedMilieux))>
            <label class="form-check-label" for="milieu-{{ $val }}">{{ $lib }}</label>
        </div>
    @endforeach
</div>

<h6 class="fw-bold mb-3">Zone(s) d'exécution géographique</h6>
{{-- RG41 : un projet peut appartenir à plusieurs zones d'exécution. --}}
@php $selectedZones = old('zones_execution', isset($projet) ? $projet->zonesExecution->pluck('id')->toArray() : []); @endphp
<div class="mb-3">
    <select name="zones_execution[]" class="form-select" multiple required size="6">
        @foreach($zones as $z)<option value="{{ $z->id }}" @selected(in_array($z->id, $selectedZones))>{{ $z->libelle }}</option>@endforeach
    </select>
    <div class="form-text">Ctrl/Cmd + clic pour sélectionner plusieurs zones. Les districts, régions, départements, communes, sous-préfectures, villages et zones hors Côte d'Ivoire sont déduits automatiquement des zones choisies.</div>
</div>
</div>
<div class="tab-pane fade" id="onglet-cibles" role="tabpanel" tabindex="0">
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

</div>
<div class="tab-pane fade" id="onglet-contexte" role="tabpanel" tabindex="0">
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
</div>
</div>
<div class="d-flex justify-content-between mt-3">
    <button type="button" class="btn btn-outline-secondary" id="onglet-precedent"><i class="bi bi-arrow-left me-1"></i>Précédent</button>
    <button type="button" class="btn btn-outline-warning" id="onglet-suivant">Suivant<i class="bi bi-arrow-right ms-1"></i></button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var onglets = document.getElementById('onglets-projet');
    if (!onglets) { return; }
    var boutons = Array.from(onglets.querySelectorAll('[data-bs-toggle="tab"]'));
    var alerte = document.getElementById('alerte-onglet');
    var prec = document.getElementById('onglet-precedent');
    var suiv = document.getElementById('onglet-suivant');
    var libre = false; // true : saut programmatique, sans contrôle des champs

    function paneDe(bouton) { return document.querySelector(bouton.getAttribute('data-bs-target')); }
    function ongletDe(champ) {
        var pane = champ.closest('.tab-pane');
        return pane ? document.querySelector('[data-bs-target="#' + pane.id + '"]') : null;
    }
    function aller(bouton) { libre = true; bootstrap.Tab.getOrCreateInstance(bouton).show(); libre = false; }
    function nomOnglet(bouton) { return bouton.textContent.replace('•', '').trim(); }
    function libelleChamp(c) {
        var l = (c.closest('.mb-3') || c.parentElement).querySelector('label');
        return l ? l.textContent.replace('*', '').trim() : (c.name || 'champ');
    }

    // Contrôle des champs obligatoires de l'onglet quitté (uniquement quand on avance).
    function valider(bouton) {
        var pane = paneDe(bouton);
        var champs = Array.from(pane.querySelectorAll('input, select, textarea'));
        champs.forEach(function (c) { c.classList.remove('is-invalid'); });
        var invalides = champs.filter(function (c) { return !c.disabled && !c.checkValidity(); });
        if (!invalides.length) { alerte.classList.add('d-none'); return true; }
        invalides.forEach(function (c) { c.classList.add('is-invalid'); });
        var noms = invalides.map(libelleChamp).filter(function (n, i, t) { return t.indexOf(n) === i; });
        alerte.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i>Veuillez remplir les champs obligatoires de l\'onglet « ' +
            nomOnglet(bouton) + ' » avant de continuer : <strong>' + noms.join(', ') + '</strong>.';
        alerte.classList.remove('d-none');
        onglets.scrollIntoView({ behavior: 'smooth', block: 'start' });
        invalides[0].focus();
        return false;
    }

    // Avancer vers un onglet situé plus loin (bouton « Suivant » ou clic direct sur l'onglet) : contrôle d'abord.
    onglets.addEventListener('show.bs.tab', function (e) {
        if (libre || !e.relatedTarget) { return; }
        if (boutons.indexOf(e.target) > boutons.indexOf(e.relatedTarget) && !valider(e.relatedTarget)) {
            e.preventDefault();
        }
    });
    document.addEventListener('input', function (e) {
        if (e.target.classList && e.target.classList.contains('is-invalid') && e.target.checkValidity()) {
            e.target.classList.remove('is-invalid');
        }
    });

    // Un champ obligatoire vide dans un onglet masqué (enregistrement) : on ouvre cet onglet.
    document.addEventListener('invalid', function (e) {
        var bouton = ongletDe(e.target);
        if (bouton && !bouton.classList.contains('active')) { aller(bouton); }
    }, true);

    // Erreurs renvoyées par le serveur : onglets concernés signalés en rouge, premier onglet ouvert.
    var erreurs = @json(array_keys($errors->messages()));
    var premier = null;
    erreurs.forEach(function (cle) {
        var nom = cle.split('.')[0];
        var champ = document.querySelector('[name="' + nom + '"], [name="' + nom + '[]"]');
        var bouton = champ ? ongletDe(champ) : null;
        if (bouton) {
            bouton.classList.add('text-danger', 'fw-bold');
            if (!bouton.textContent.includes('•')) { bouton.insertAdjacentText('beforeend', ' •'); }
            premier = premier || bouton;
        }
    });
    if (premier) { aller(premier); }

    // Boutons Précédent / Suivant
    function courant() { return boutons.findIndex(function (b) { return b.classList.contains('active'); }); }
    function maj() { var i = courant(); prec.disabled = i <= 0; suiv.disabled = i >= boutons.length - 1; }
    prec.addEventListener('click', function () { var i = courant(); if (i > 0) { aller(boutons[i - 1]); } });
    suiv.addEventListener('click', function () { var i = courant(); if (i < boutons.length - 1) { bootstrap.Tab.getOrCreateInstance(boutons[i + 1]).show(); } });
    boutons.forEach(function (b) {
        b.addEventListener('shown.bs.tab', function () {
            alerte.classList.add('d-none');
            maj();
            onglets.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    maj();
});
</script>
