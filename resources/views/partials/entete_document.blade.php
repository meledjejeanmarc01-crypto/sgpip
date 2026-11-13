{{-- En-tête officiel d'un document : armoiries, République, ministère, bande orange · blanc · vert.
     Par défaut visible seulement à l'impression ; $visibleEcran = true pour l'afficher aussi à l'écran. --}}
<div class="plh {{ ($visibleEcran ?? false) ? '' : 'print-only' }}">
    <div class="plh-top">
        <div class="plh-left">
            <img src="{{ asset('images/armoiries-logo.png') }}" alt="Armoiries de la Côte d'Ivoire" class="plh-logo">
            <div>
                <div class="plh-republique">République de Côte d'Ivoire</div>
                <div class="plh-devise">Union &middot; Discipline &middot; Travail</div>
            </div>
        </div>
        <div class="plh-right">
            <div class="plh-ministere">Ministère du Plan et du Développement</div>
            <div class="plh-systeme">SGSPIP &mdash; Système Intégré de Gestion et de Suivi des Projets d'Investissement Public</div>
        </div>
    </div>
    <div class="flag-band"><span></span><span></span><span></span></div>
</div>
