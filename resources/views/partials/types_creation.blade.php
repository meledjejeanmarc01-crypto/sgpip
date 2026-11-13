{{--
  Création d'un type directement depuis le formulaire qui l'utilise.
  Tout <select data-creer-url="..."> reçoit l'option « Créer un nouveau… » : un petit champ apparaît sur place,
  le type est enregistré, ajouté à toutes les listes concernées de la page et sélectionné.
--}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var CSRF = @json(csrf_token());

    function preparer(sel) {
        if (sel.dataset.creerInit) { return; }
        sel.dataset.creerInit = '1';
        var opt = document.createElement('option');
        opt.value = '__nouveau__';
        opt.textContent = '➕ Créer un nouveau…';
        sel.appendChild(opt);
        sel.dataset.prec = sel.value;
    }
    // Les types et référentiels se créent via des routes réservées à l'administrateur (config/acces.php) :
    // on ne propose « Créer un nouveau… » qu'à lui, pour éviter une erreur 403 aux autres rôles.
    if (@json((bool) auth()->user()?->isAdministrateur())) {
        document.querySelectorAll('select[data-creer-url]').forEach(preparer);
    }

    document.addEventListener('change', function (e) {
        var sel = e.target;
        if (!(sel instanceof HTMLSelectElement) || !sel.dataset.creerUrl) { return; }
        if (sel.value === '__nouveau__') { sel.value = sel.dataset.prec || ''; ouvrir(sel); }
        else { sel.dataset.prec = sel.value; }
    });

    function ouvrir(sel) {
        if (sel._zone) { sel._zone.querySelector('input').focus(); return; }
        var zone = document.createElement('div');
        zone.className = 'mt-1';
        zone.innerHTML = '<div class="input-group input-group-sm">' +
            '<input type="text" class="form-control" maxlength="255" placeholder="' + (sel.dataset.creerNom || 'Nom du nouveau type') + '">' +
            '<button type="button" class="btn btn-primary" data-act="ok">Créer</button>' +
            '<button type="button" class="btn btn-outline-secondary" data-act="x" title="Annuler">✕</button></div>' +
            '<div class="small text-danger mt-1 d-none"></div>';
        sel.insertAdjacentElement('afterend', zone);
        sel.classList.add('d-none');
        sel._zone = zone;
        var champ = zone.querySelector('input'), erreur = zone.querySelector('.text-danger');

        function fermer() { zone.remove(); sel._zone = null; sel.classList.remove('d-none'); }
        function creer() {
            var libelle = champ.value.trim();
            if (!libelle) { erreur.textContent = 'Saisissez un nom.'; erreur.classList.remove('d-none'); return; }
            var donnees = new FormData();
            donnees.append('libelle', libelle);
            zone.querySelector('[data-act="ok"]').disabled = true;
            fetch(sel.dataset.creerUrl, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
                body: donnees
            }).then(function (r) { return r.json().then(function (j) { return { ok: r.ok, json: j }; }); })
              .then(function (res) {
                zone.querySelector('[data-act="ok"]').disabled = false;
                if (!res.ok) {
                    var msgs = res.json && res.json.errors ? [].concat.apply([], Object.keys(res.json.errors).map(function (k) { return res.json.errors[k]; })) : [(res.json && res.json.message) || 'Erreur lors de la création.'];
                    erreur.textContent = msgs.join(' ');
                    erreur.classList.remove('d-none');
                    return;
                }
                // Le nouveau type est ajouté à toutes les listes de la page qui utilisent la même adresse.
                document.querySelectorAll('select[data-creer-url]').forEach(function (autre) {
                    if (autre.dataset.creerUrl !== sel.dataset.creerUrl) { return; }
                    if (!Array.from(autre.options).some(function (o) { return o.value === String(res.json.id); })) {
                        var o = document.createElement('option');
                        o.value = res.json.id; o.textContent = res.json.libelle;
                        autre.insertBefore(o, autre.querySelector('option[value="__nouveau__"]'));
                    }
                });
                sel.value = res.json.id;
                sel.dataset.prec = sel.value;
                sel.classList.remove('is-invalid');
                fermer();
            }).catch(function () {
                zone.querySelector('[data-act="ok"]').disabled = false;
                erreur.textContent = 'Erreur de connexion. Réessayez.';
                erreur.classList.remove('d-none');
            });
        }
        zone.addEventListener('click', function (e) {
            var b = e.target.closest('button');
            if (!b) { return; }
            if (b.dataset.act === 'ok') { creer(); } else if (b.dataset.act === 'x') { fermer(); }
        });
        champ.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); creer(); }
            else if (e.key === 'Escape') { e.preventDefault(); fermer(); }
        });
        champ.focus();
    }
});
</script>
