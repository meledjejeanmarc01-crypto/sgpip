{{--
  Champ à saisie assistée (structure, secteur, action PND, axe) avec création rapide.
  Variables : $nom (structure_id | secteur_id | action_pnd_id | axe_id), $label, $items (id, libelle, sigle), $selected,
  $type ('structure' | 'secteur' | 'action_pnd' | 'axe'), $obligatoire (facultatif, vrai par défaut)
--}}
@php
    $est = $type === 'structure';
    $obligatoire = $obligatoire ?? true;
    $parametres = [
        'structure'  => ['titre' => 'Nouvelle structure',   'exemple' => 'ex : MIN, DSID…',     'feminin' => true,  'url' => route('structures.store')],
        'secteur'    => ['titre' => 'Nouveau secteur',      'exemple' => 'ex : AGR, Santé…',    'feminin' => false, 'url' => route('secteurs.store')],
        'action_pnd' => ['titre' => 'Nouvelle action PND',  'exemple' => 'ex : Action 1.2…',    'feminin' => true,  'url' => route('actions-pnd.store')],
        'axe'        => ['titre' => 'Nouvel axe',           'exemple' => 'ex : Axe 1…',         'feminin' => false, 'url' => route('axes.store', ['programme' => '__PROGRAMME__'])],
    ][$type];
    $titreNouveau = $parametres['titre'];
    $exemple = $parametres['exemple'];
    $typesStructure = $est ? \App\Models\TypeStructure::orderBy('libelle')->get() : collect();
    $programmes = $type === 'axe' ? \App\Models\Programme::orderBy('nom')->get() : collect();
    $moduleAcces = ['structure' => 'structures', 'secteur' => 'secteurs', 'action_pnd' => 'actions-pnd', 'axe' => 'axes'][$type];
    $peutCreer = auth()->user()?->peutModifier($moduleAcces) ?? false;  // matrice config/acces.php
@endphp
<div class="mb-3 position-relative" id="ac-{{ $nom }}">
    <label class="form-label" for="{{ $nom }}-saisie">{{ $label }} @if($obligatoire)<span class="text-danger">*</span>@endif</label>
    <div class="input-group">
        <input type="text" id="{{ $nom }}-saisie" class="form-control" autocomplete="off" @if($obligatoire) required @endif placeholder="Tapez pour rechercher ({{ $exemple }})">
        @if($peutCreer)
            <button type="button" class="btn btn-outline-primary" id="{{ $nom }}-nouveau" title="{{ $titreNouveau }}"><i class="bi bi-plus-lg"></i> <span class="d-none d-xl-inline">{{ $parametres['feminin'] ? 'Nouvelle' : 'Nouveau' }}</span></button>
        @endif
    </div>
    <input type="hidden" name="{{ $nom }}" id="{{ $nom }}-id" value="{{ $selected }}">
    <div class="list-group shadow position-absolute w-100 d-none" id="{{ $nom }}-liste" style="z-index: 1050; max-height: 260px; overflow-y: auto;"></div>
</div>

{{-- Fenêtre de création rapide (déplacée dans <body> par le script, pour éviter un formulaire imbriqué) --}}
<div class="modal fade" id="{{ $nom }}-modal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">{{ $titreNouveau }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="alert alert-danger d-none" id="{{ $nom }}-modal-erreur"></div>
            <div class="mb-3">
                <label class="form-label">Libellé <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="{{ $nom }}-m-libelle" maxlength="255">
            </div>
            @if($type === 'action_pnd')
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="{{ $nom }}-m-description" rows="3"></textarea>
                </div>
            @endif
            @if($type === 'axe')
                <div class="mb-3">
                    <label class="form-label">Programme <span class="text-danger">*</span></label>
                    <select class="form-select" id="{{ $nom }}-m-programme">
                        <option value="">-- Choisir --</option>
                        @foreach($programmes as $p)<option value="{{ $p->id }}">{{ $p->nom }}</option>@endforeach
                    </select>
                </div>
            @endif
            @if($est)
                <div class="mb-3">
                    <label class="form-label">Sigle</label>
                    <input type="text" class="form-control" id="{{ $nom }}-m-sigle" maxlength="50">
                </div>
                <div class="mb-3">
                    <label class="form-label">Type de structure <span class="text-danger">*</span></label>
                    <select class="form-select" id="{{ $nom }}-m-type" data-creer-url="{{ route('types-structure.store') }}" data-creer-nom="Nom du nouveau type de structure">
                        <option value="">-- Choisir --</option>
                        @foreach($typesStructure as $t)<option value="{{ $t->id }}">{{ $t->libelle }}</option>@endforeach
                    </select>
                </div>
                <a href="{{ route('structures.create') }}" target="_blank" class="small">Ouvrir le formulaire complet (adresse, téléphone, e-mail)</a>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
            <button type="button" class="btn btn-primary" id="{{ $nom }}-m-enregistrer">Créer et sélectionner</button>
        </div>
    </div></div>
</div>

<script>
(function () {
    var NOM = @json($nom);
    var TYPE = @json($type);
    var EST_STRUCTURE = TYPE === 'structure';
    var OBLIGATOIRE = @json($obligatoire);
    var PEUT_CREER = @json($peutCreer);
    var FEMININ = @json($parametres['feminin']);
    var URL_CREATION = @json($parametres['url']);
    var CSRF = @json(csrf_token());
    var items = @json($items);

    var saisie = document.getElementById(NOM + '-saisie');
    var cache = document.getElementById(NOM + '-id');
    var liste = document.getElementById(NOM + '-liste');
    var btnNouveau = document.getElementById(NOM + '-nouveau');
    var modalEl = document.getElementById(NOM + '-modal');
    var erreurEl = document.getElementById(NOM + '-modal-erreur');
    var mLibelle = document.getElementById(NOM + '-m-libelle');
    var mSigle = document.getElementById(NOM + '-m-sigle');
    var mType = document.getElementById(NOM + '-m-type');
    var mDescription = document.getElementById(NOM + '-m-description');
    var mProgramme = document.getElementById(NOM + '-m-programme');
    var mEnregistrer = document.getElementById(NOM + '-m-enregistrer');
    var actif = -1;
    var resultats = [];

    document.body.appendChild(modalEl);   // la fenêtre sort du formulaire de projet

    function norm(t) { return String(t || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim(); }
    function esc(t) { return String(t == null ? '' : t).replace(/[&<>"']/g, function (c) { return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[c]; }); }
    function etiquette(it) { return it.libelle + (it.sigle ? ' (' + it.sigle + ')' : ''); }

    function majValidite() {
        // Champ facultatif laissé vide : valide. Sinon, il faut un élément de la liste.
        if (!OBLIGATOIRE && !saisie.value.trim()) { saisie.setCustomValidity(''); return; }
        saisie.setCustomValidity(cache.value ? '' : 'Choisissez dans la liste, ou créez-' + (FEMININ ? 'la' : 'le') + ' avec le bouton +.');
    }
    function choisir(it) {
        cache.value = it.id;
        saisie.value = it.libelle;
        saisie.classList.remove('is-invalid');
        fermer();
        majValidite();
    }
    function fermer() { liste.classList.add('d-none'); actif = -1; }

    // Classement : début du libellé, début du sigle, début d'un mot, puis simple inclusion.
    function chercher(terme) {
        var t = norm(terme);
        var res = [];
        items.forEach(function (it) {
            var l = norm(it.libelle), s = norm(it.sigle), score = null;
            if (!t) { score = 5; }
            else if (l.indexOf(t) === 0) { score = 0; }
            else if (s && s.indexOf(t) === 0) { score = 1; }
            else if (l.split(/[^a-z0-9]+/).some(function (m) { return m.indexOf(t) === 0; })) { score = 2; }
            else if (l.indexOf(t) !== -1 || (s && s.indexOf(t) !== -1)) { score = 3; }
            if (score !== null) { res.push({ it: it, score: score, l: l }); }
        });
        res.sort(function (a, b) { return a.score - b.score || a.l.localeCompare(b.l); });
        return res.slice(0, 8).map(function (r) { return r.it; });
    }
    function surligner(texte, terme) {
        var t = norm(terme);
        if (!t) { return esc(texte); }
        var i = norm(texte).indexOf(t);
        if (i < 0) { return esc(texte); }
        return esc(texte.slice(0, i)) + '<strong>' + esc(texte.slice(i, i + t.length)) + '</strong>' + esc(texte.slice(i + t.length));
    }

    function afficher() {
        var terme = saisie.value;
        resultats = chercher(terme);
        var html = resultats.map(function (it, i) {
            return '<button type="button" class="list-group-item list-group-item-action' + (i === actif ? ' active' : '') + '" data-i="' + i + '">' +
                surligner(it.libelle, terme) + (it.sigle ? ' <small class="opacity-75">(' + esc(it.sigle) + ')</small>' : '') + '</button>';
        }).join('');
        if (PEUT_CREER && terme.trim()) {
            html += '<button type="button" class="list-group-item list-group-item-action text-primary" data-creer="1"><i class="bi bi-plus-circle me-1"></i>' +
                (resultats.length ? 'Créer' : 'Aucun résultat : créer') + ' « ' + esc(terme.trim()) + ' »</button>';
        }
        if (!html) { fermer(); return; }
        liste.innerHTML = html;
        liste.classList.remove('d-none');
    }

    saisie.addEventListener('input', function () {
        // Toute frappe annule le choix précédent, sauf si le texte correspond exactement à un élément.
        cache.value = '';
        var exact = items.filter(function (it) { return norm(it.libelle) === norm(saisie.value); });
        if (exact.length === 1 && saisie.value.trim()) { cache.value = exact[0].id; }
        majValidite();
        actif = -1;
        afficher();
    });
    saisie.addEventListener('focus', afficher);
    saisie.addEventListener('keydown', function (e) {
        var visible = !liste.classList.contains('d-none');
        if (e.key === 'ArrowDown' && visible) { e.preventDefault(); actif = Math.min(actif + 1, resultats.length - 1); afficher(); }
        else if (e.key === 'ArrowUp' && visible) { e.preventDefault(); actif = Math.max(actif - 1, 0); afficher(); }
        else if (e.key === 'Enter') {
            if (visible && resultats.length) { e.preventDefault(); choisir(resultats[actif >= 0 ? actif : 0]); }
            else if (visible) { e.preventDefault(); }
        }
        else if (e.key === 'Escape') { fermer(); }
    });
    liste.addEventListener('mousedown', function (e) {
        var b = e.target.closest('button');
        if (!b) { return; }
        e.preventDefault();
        if (b.dataset.creer) { ouvrirCreation(saisie.value.trim()); }
        else { choisir(resultats[parseInt(b.dataset.i, 10)]); }
    });
    document.addEventListener('click', function (e) { if (!document.getElementById('ac-' + NOM).contains(e.target)) { fermer(); } });

    // Valeur initiale (modification d'un projet ou retour après une erreur de validation)
    var initial = items.filter(function (it) { return String(it.id) === String(cache.value); })[0];
    if (initial) { saisie.value = initial.libelle; }
    majValidite();

    // Création rapide
    function ouvrirCreation(texte) {
        erreurEl.classList.add('d-none');
        mLibelle.value = texte || '';
        if (mSigle) { mSigle.value = ''; }
        if (mType) { mType.value = ''; }
        if (mDescription) { mDescription.value = ''; }
        if (mProgramme) { mProgramme.value = ''; }
        fermer();
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
        setTimeout(function () { mLibelle.focus(); }, 300);
    }
    if (btnNouveau) { btnNouveau.addEventListener('click', function () { ouvrirCreation(saisie.value.trim()); }); }
    modalEl.addEventListener('keydown', function (e) { if (e.key === 'Enter' && e.target.tagName === 'INPUT') { e.preventDefault(); mEnregistrer.click(); } });

    mEnregistrer.addEventListener('click', function () {
        var donnees = new FormData();
        donnees.append('libelle', mLibelle.value.trim());
        var url = URL_CREATION;
        if (EST_STRUCTURE) {
            donnees.append('sigle', mSigle.value.trim());
            donnees.append('type_structure_id', mType.value);
        }
        if (TYPE === 'action_pnd') {
            donnees.append('description', mDescription.value.trim());
        }
        if (TYPE === 'axe') {
            if (!mProgramme.value) {
                erreurEl.textContent = 'Choisissez le programme auquel rattacher cet axe.';
                erreurEl.classList.remove('d-none');
                return;
            }
            url = URL_CREATION.replace('__PROGRAMME__', mProgramme.value);
        }
        mEnregistrer.disabled = true;
        fetch(url, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
            body: donnees
        }).then(function (r) {
            return r.json().then(function (j) { return { ok: r.ok, status: r.status, json: j }; });
        }).then(function (res) {
            mEnregistrer.disabled = false;
            if (!res.ok) {
                var msgs = res.json && res.json.errors ? [].concat.apply([], Object.keys(res.json.errors).map(function (k) { return res.json.errors[k]; })) : [(res.json && res.json.message) || 'Erreur lors de la création.'];
                erreurEl.innerHTML = msgs.map(esc).join('<br>');
                erreurEl.classList.remove('d-none');
                return;
            }
            items.push({ id: res.json.id, libelle: res.json.libelle, sigle: res.json.sigle || '' });
            choisir(res.json);
            bootstrap.Modal.getOrCreateInstance(modalEl).hide();
        }).catch(function () {
            mEnregistrer.disabled = false;
            erreurEl.textContent = 'Erreur de connexion. Réessayez.';
            erreurEl.classList.remove('d-none');
        });
    });
})();
</script>
