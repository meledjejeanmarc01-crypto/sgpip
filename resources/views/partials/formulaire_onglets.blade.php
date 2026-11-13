{{-- Style et comportement des formulaires à onglets (même rendu que la fiche projet).
     À inclure à la fin d'un formulaire qui contient : <ul id="onglets-formulaire">, <div id="alerte-onglet">,
     des <div class="tab-pane"> et les boutons #onglet-precedent / #onglet-suivant. --}}
<style>
    .form-tabs .nav-link { border: 1px solid #dee2e6; background: #fff; color: #495057; border-radius: 2rem; padding: .4rem 1.1rem; font-weight: 500; transition: all .15s ease; }
    .form-tabs .nav-link:hover { border-color: #FF8200; color: #E06E00; }
    .form-tabs .nav-link.active { background: #FF8200; border-color: #FF8200; color: #fff; box-shadow: 0 2px 8px rgba(255,130,0,.3); }
    .form-tabs .nav-link.text-danger:not(.active) { border-color: #dc3545; }
    .form-tab-content { background: #fff; border: 1px solid #eef0f3; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 1px 4px rgba(0,0,0,.04); }
    .form-tab-content h6 { color: #E06E00; border-bottom: 2px solid #FFE3C7; padding-bottom: .4rem; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var onglets = document.getElementById('onglets-formulaire');
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
