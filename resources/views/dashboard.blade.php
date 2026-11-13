@extends('layouts.app')
@section('page-title', 'Tableau de bord')
@section('bg', 'bg-infra')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --db-orange: #F4992A;
        --db-orange-deep: #BF7014;
        --db-vert: #009A44;
        --db-vert-deep: #007131;
        --db-ink: #1C2024;
        --db-sable: #F6F1E7;
        --db-sable-line: #E9E0CE;
        --db-line: #E7E9EC;
        --db-red: #B3221E;
        --db-muted: #6B7280;
    }
    .db-display { font-family: 'Space Grotesk', 'Inter', sans-serif; }
    .db-body { font-family: 'Inter', sans-serif; }

    .db-hero {
        background: linear-gradient(120deg, var(--db-vert-deep) 0%, var(--db-vert) 60%, #1FB35E 100%);
        border-radius: 1rem;
        color: #fff;
        padding: 2rem 2.25rem;
        position: relative;
        overflow: hidden;
    }
    .db-hero::after {
        content: "";
        position: absolute;
        right: -60px; top: -60px;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
    }
    .db-hero-eyebrow { font-size: .78rem; letter-spacing: .02em; color: rgba(255,255,255,.85); }
    .db-hero-title { font-size: 1.9rem; font-weight: 700; line-height: 1.15; margin: .15rem 0 .35rem; }
    .db-hero-sub { color: rgba(255,255,255,.9); font-size: .95rem; }

    .db-progress-row { margin-bottom: .9rem; }
    .db-progress-row:last-child { margin-bottom: 0; }
    .db-progress-head { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: .3rem; }
    .db-progress-label { color: rgba(255,255,255,.92); font-size: .85rem; }
    .db-progress-value { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 1.15rem; color: #fff; }
    .db-progress-track { background: rgba(255,255,255,.28); border-radius: 999px; height: 10px; overflow: hidden; }
    .db-progress-fill { background: #fff; height: 100%; border-radius: 999px; }

    .db-section-label {
        font-size: .78rem; font-weight: 600; letter-spacing: .01em;
        color: var(--db-muted); margin: 1.75rem 0 .75rem;
    }
    .db-section-label:first-of-type { margin-top: 0; }

    .db-stat {
        background: #fff; border: 1px solid var(--db-line); border-left: 4px solid var(--db-orange);
        border-radius: .6rem; padding: .85rem 1rem; height: 100%;
        display: flex; align-items: center; gap: .75rem;
    }
    .db-stat.is-positive { border-left-color: var(--db-vert); }
    .db-stat.is-alert { border-left-color: var(--db-red); background: #FDF4F3; }
    .db-stat.is-neutral { border-left-color: #C9CDD3; }
    .db-stat-icon { font-size: 1.15rem; color: var(--db-muted); width: 1.6rem; text-align: center; }
    .db-stat.is-positive .db-stat-icon { color: var(--db-vert); }
    .db-stat.is-alert .db-stat-icon { color: var(--db-red); }
    .db-stat-value { font-family: 'Space Grotesk', sans-serif; font-size: 1.45rem; font-weight: 700; color: var(--db-ink); line-height: 1; }
    .db-stat.is-alert .db-stat-value { color: var(--db-red); }
    .db-stat-label { font-size: .78rem; color: var(--db-muted); }

    .db-finances {
        background: var(--db-sable); border: 1px solid var(--db-sable-line);
        border-radius: .75rem; padding: 1.25rem 1.5rem;
    }
    .db-fin-value { font-family: 'Space Grotesk', sans-serif; font-size: 1.35rem; font-weight: 700; color: var(--db-ink); cursor: help; }
    .db-fin-label { font-size: .78rem; color: var(--db-muted); margin-bottom: .15rem; }
    .db-fin-unit { font-size: .8rem; font-weight: 500; color: var(--db-muted); }

    .db-chip {
        border: 1px solid var(--db-line); border-radius: 999px;
        padding: .5rem 1rem; display: inline-flex; align-items: center; gap: .55rem;
        background: #fff;
    }
    .db-chip i { color: var(--db-orange); }
    .db-chip b { font-family: 'Space Grotesk', sans-serif; color: var(--db-ink); }
    .db-chip span.db-chip-label { color: var(--db-muted); font-size: .85rem; }

    .db-panel { background: #fff; border: 1px solid var(--db-line); border-radius: .75rem; padding: 1.1rem; }
    .db-panel-title { font-size: .82rem; font-weight: 600; color: var(--db-ink); margin: 0; display:flex; align-items:center; gap:.4rem; }
    .db-panel-title i { color: var(--db-orange); }
    .db-row-line { border-bottom: 1px solid var(--db-line); padding: .45rem 0; }
    .db-row-line:last-child { border-bottom: none; }
</style>
@endpush

@section('content')
@php
    $md = fn ($valeur) => number_format(((float) $valeur) / 1000000000, 2, ',', ' ');
    $fcfa = fn ($valeur) => number_format((float) $valeur, 0, ',', ' ').' FCFA';
    $physique = (float) $stats['avancement_physique_moyen'];
    $financier = (float) $stats['avancement_financier_moyen'];
@endphp
<div class="db-body">

    {{-- HERO --}}
    <div class="db-hero mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="db-hero-eyebrow">Portefeuille des projets d'investissement public &middot; Côte d'Ivoire</div>
                <div class="db-hero-title db-display">{{ $stats['total_projets'] }} projets suivis</div>
                <div class="db-hero-sub">{{ $md($stats['montant_total_projets']) }} milliards FCFA de coût estimatif cumulé, répartis sur {{ $zonesCarteData->count() }} zones d'exécution.</div>
            </div>
            <div class="col-lg-5">
                <div class="db-progress-row">
                    <div class="db-progress-head">
                        <span class="db-progress-label">Avancement physique</span>
                        <span class="db-progress-value">{{ number_format($physique, 1, ',', '') }}%</span>
                    </div>
                    <div class="db-progress-track"><div class="db-progress-fill" style="width: {{ min($physique, 100) }}%;"></div></div>
                </div>
                <div class="db-progress-row">
                    <div class="db-progress-head">
                        <span class="db-progress-label">Avancement financier</span>
                        <span class="db-progress-value">{{ number_format($financier, 1, ',', '') }}%</span>
                    </div>
                    <div class="db-progress-track"><div class="db-progress-fill" style="width: {{ min($financier, 100) }}%;"></div></div>
                </div>
            </div>
        </div>
    </div>

    {{-- PROJETS PAR STATUT --}}
    <div class="db-section-label">Projets par statut</div>
    <div class="row g-3">
        <div class="col-6 col-lg">
            <div class="db-stat is-neutral">
                <i class="bi bi-kanban db-stat-icon"></i>
                <div><div class="db-stat-value">{{ $stats['total_projets'] }}</div><div class="db-stat-label">Total</div></div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="db-stat">
                <i class="bi bi-play-circle db-stat-icon"></i>
                <div><div class="db-stat-value">{{ $stats['projets_en_cours'] }}</div><div class="db-stat-label">En cours</div></div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="db-stat is-positive">
                <i class="bi bi-check-circle db-stat-icon"></i>
                <div><div class="db-stat-value">{{ $stats['projets_termines'] }}</div><div class="db-stat-label">Terminés</div></div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="db-stat is-neutral">
                <i class="bi bi-hourglass-split db-stat-icon"></i>
                <div><div class="db-stat-value">{{ $stats['projets_planifies'] }}</div><div class="db-stat-label">Planifiés</div></div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="db-stat is-neutral">
                <i class="bi bi-exclamation-triangle db-stat-icon"></i>
                <div><div class="db-stat-value">{{ $stats['projets_retardes'] }}</div><div class="db-stat-label">En retard</div></div>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="db-stat {{ $stats['projets_suspendus'] ? 'is-alert' : 'is-neutral' }}">
                <i class="bi bi-pause-circle db-stat-icon"></i>
                <div><div class="db-stat-value">{{ $stats['projets_suspendus'] }}</div><div class="db-stat-label">Suspendus</div></div>
            </div>
        </div>
    </div>

    {{-- FINANCES --}}
    <div class="db-section-label">Finances</div>
    <div class="db-finances">
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="db-fin-label">Coût estimatif total</div>
                <div class="db-fin-value" title="{{ $fcfa($stats['montant_total_projets']) }}">{{ $md($stats['montant_total_projets']) }} <span class="db-fin-unit">Md FCFA</span></div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="db-fin-label">Financement (Dotation)</div>
                <div class="db-fin-value" title="{{ $fcfa($stats['montant_engage']) }}">{{ $md($stats['montant_engage']) }} <span class="db-fin-unit">Md FCFA</span></div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="db-fin-label">Décaissé (Fond disponible)</div>
                <div class="db-fin-value" title="{{ $fcfa($stats['montant_decaisse']) }}">{{ $md($stats['montant_decaisse']) }} <span class="db-fin-unit">Md FCFA</span></div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="db-fin-label">Dépensé (Exécution)</div>
                <div class="db-fin-value" title="{{ $fcfa($stats['montant_depense']) }}">{{ $md($stats['montant_depense']) }} <span class="db-fin-unit">Md FCFA</span></div>
            </div>
        </div>
    </div>

    {{-- RESSOURCES --}}
    <div class="db-section-label">Ressources</div>
    <div class="d-flex flex-wrap gap-2">
        <div class="db-chip"><i class="bi bi-bank"></i><b>{{ $stats['total_bailleurs'] }}</b><span class="db-chip-label">bailleurs</span></div>
        <div class="db-chip"><i class="bi bi-building"></i><b>{{ $stats['total_structures'] }}</b><span class="db-chip-label">structures</span></div>
        <div class="db-chip"><i class="bi bi-bar-chart-line"></i><b>{{ $stats['total_rapports'] }}</b><span class="db-chip-label">rapports</span></div>
        <div class="db-chip"><i class="bi bi-file-earmark"></i><b>{{ $stats['total_documents'] }}</b><span class="db-chip-label">documents</span></div>
    </div>

    {{-- CARTE + PROJETS RECENTS --}}
    <div class="row g-3 mt-1">
        <div class="col-lg-7">
            <div class="db-panel">
                <h6 class="db-panel-title mb-1"><i class="bi bi-geo-alt"></i>Carte des projets</h6>
                <div class="text-muted mb-2" style="font-size:.78rem;"></div>

                <div id="carte-resume" class="d-flex flex-wrap gap-2 mb-2"></div>

                <div id="map" style="height: 340px; border-radius:.5rem;"></div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="db-panel">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="db-panel-title m-0"><i class="bi bi-clock-history"></i><span id="recents-titre">Projets récents</span></h6>
                    <a href="{{ route('projets.index') }}" class="small text-decoration-none">Voir tout</a>
                </div>
                <div id="recents-liste" style="max-height:380px; overflow-y:auto;">
                @foreach($projetsRecents->take(5) as $p)
                    <div class="d-flex justify-content-between align-items-center db-row-line">
                        <div class="text-truncate me-2">
                            <a href="{{ route('projets.show', $p) }}" class="fw-semibold text-decoration-none small">{{ $p->intitule }}</a>
                            <div class="small text-muted text-truncate">{{ $p->secteur->libelle ?? '' }}</div>
                        </div>
                        <span class="badge badge-statut-{{ $p->statut }}">{{ str_replace('_',' ',$p->statut) }}</span>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- TOP SECTEURS + ZONES --}}
    <div class="row g-3 mt-1">
        <div class="col-lg-6">
            <div class="db-panel">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="db-panel-title m-0"><i class="bi bi-grid"></i>Tous les  secteurs</h6>
                    <a href="{{ route('projets.index') }}" class="small text-decoration-none">Voir tout</a>
                </div>
                <div class="mb-2">
                    <select id="filtre-secteur" class="form-select form-select-sm" aria-label="Choisir un secteur">
                        <option value="">Tous les secteurs</option>
                        @foreach($secteursFiltre as $sf)
                            <option value="{{ $sf['id'] }}">{{ $sf['libelle'] }}</option>
                        @endforeach
                    </select>
                </div>
                @foreach($projetsParSecteur->take(6) as $s)
                    <div class="d-flex justify-content-between db-row-line">
                        <span class="text-muted text-truncate me-2 small">{{ $s->libelle }}</span>
                        <span class="fw-semibold small">{{ $s->projets_count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-6">
            <div class="db-panel">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="db-panel-title m-0"><i class="bi bi-signpost-2"></i>Statistiques par zone d'exécution</h6>
                    <a href="{{ route('zones.index') }}" class="small text-decoration-none">Voir tout</a>
                </div>
                <div class="mb-2">
                    <select id="filtre-zone" class="form-select form-select-sm" aria-label="Choisir une zone d'exécution">
                        <option value="">Toutes les zones</option>
                        @foreach($zonesFiltre as $zf)
                            <option value="{{ $zf['id'] }}">{{ $zf['libelle'] }}</option>
                        @endforeach
                    </select>
                </div>
                @forelse($projetsParZoneStat as $z)
                    <div class="db-row-line">
                        <span class="text-muted text-truncate small">{{ $z->libelle }}</span>
                    </div>
                @empty
                    <div class="text-muted small">Aucune zone d'exécution.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}" />
<script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
<script>
    const map = L.map('map').setView([7.5399, -5.5471], 6.5); // centre Côte d'Ivoire
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const zones = @json($zonesCarteData);        // zones avec coordonnées (marqueurs)
    const projets = @json($projetsIndex);
    projets.forEach(p => { p.zone_ids = p.zone_ids.map(String); });

    const fmtMontant = v => new Intl.NumberFormat('fr-FR').format(Math.round(v)) + ' FCFA';
    const fmtPct = v => (Math.round(v * 10) / 10).toString().replace('.', ',') + '%';
    const libStatut = s => { const t = String(s ?? '').replace(/_/g, ' '); return t.charAt(0).toUpperCase() + t.slice(1); };
    const esc = t => String(t ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

    function stats(liste) {
        const nb = liste.length;
        const montant = liste.reduce((t, p) => t + p.cout, 0);
        const avancement = nb ? liste.reduce((t, p) => t + p.avancement, 0) / nb : 0;
        return { nb, montant, avancement };
    }

    const couche = L.layerGroup().addTo(map);
    const selSecteur = document.getElementById('filtre-secteur');
    const selZone = document.getElementById('filtre-zone');
    const resume = document.getElementById('carte-resume');
    const recentsListe = document.getElementById('recents-liste');
    const recentsTitre = document.getElementById('recents-titre');
    const recentsDefaut = recentsListe.innerHTML;   // les 5 projets récents affichés par défaut

    // Un rond par zone, calculé sur les projets sélectionnés de cette zone.
    function marqueurZone(z, liste) {
        const s = stats(liste);
        const d = 30 + Math.min(s.nb, 10) * 4; // diamètre du rond : suit le nombre de projets
        const r = d / 2 - 4;
        const c = 2 * Math.PI * r;
        const avancement = Math.max(0, Math.min(s.avancement, 100));
        const dash = c * avancement / 100;

        const icone = L.divIcon({
            className: '',
            iconSize: [d, d],
            iconAnchor: [d / 2, d / 2],
            html: `
                <svg width="${d}" height="${d}" viewBox="0 0 ${d} ${d}">
                    <circle cx="${d/2}" cy="${d/2}" r="${r}" fill="#fff" stroke="#E7E9EC" stroke-width="4"/>
                    <circle cx="${d/2}" cy="${d/2}" r="${r}" fill="none" stroke="#009A44" stroke-width="4"
                        stroke-dasharray="${dash.toFixed(1)} ${c.toFixed(1)}" stroke-linecap="round"
                        transform="rotate(-90 ${d/2} ${d/2})"/>
                    <text x="${d/2}" y="${d/2 + d*0.07}" text-anchor="middle" font-size="${d*0.26}" font-weight="700" fill="#1C2024">${Math.round(avancement)}%</text>
                </svg>`
        });

        const detail = liste.slice(0, 8).map(p =>
            `<div class="mb-1"><a href="${esc(p.url)}">${esc(p.intitule)}</a><br>` +
            `<span class="text-muted">${fmtMontant(p.cout)} · ${esc(libStatut(p.statut))} · ${fmtPct(p.avancement)}</span></div>`).join('');
        const reste = liste.length > 8 ? `<div class="text-muted">+ ${liste.length - 8} autre(s) projet(s)</div>` : '';

        const popup = `<strong>${esc(z.libelle)}</strong><br>${esc(z.type)}<br>` +
            `${s.nb} projet(s) · ${fmtMontant(s.montant)}<br>Avancement moyen : ${fmtPct(s.avancement)}` +
            `<hr class="my-1"><div style="max-height:180px; overflow-y:auto; font-size:.8rem;">${detail}${reste}</div>`;
        return L.marker([z.lat, z.lng], { icon: icone }).bindPopup(popup, { minWidth: 220 });
    }

    function chip(icone, valeur, label) {
        return `<div class="db-chip"><i class="bi ${icone}"></i><b>${valeur}</b><span class="db-chip-label">${label}</span></div>`;
    }

    // Affiche dans « Projets récents » les projets sélectionnés (montant, statut, avancement).
    function afficherListe(liste, actif) {
        if (!actif) {
            recentsTitre.textContent = 'Projets récents';
            recentsListe.innerHTML = recentsDefaut;
            return;
        }
        recentsTitre.textContent = `Projets sélectionnés (${liste.length})`;
        recentsListe.innerHTML = liste.length ? liste.map(p => `
            <div class="d-flex justify-content-between align-items-start db-row-line">
                <div class="text-truncate me-2">
                    <a href="${esc(p.url)}" class="fw-semibold text-decoration-none small">${esc(p.intitule)}</a>
                    <div class="small text-muted text-truncate">${esc(p.secteur ?? '')}${p.zones ? ' · ' + esc(p.zones) : ''}</div>
                    <div class="small text-muted">${fmtMontant(p.cout)} · Avancement : ${fmtPct(p.avancement)}</div>
                </div>
                <span class="badge badge-statut-${esc(p.statut)}">${esc(libStatut(p.statut))}</span>
            </div>`).join('') : '<div class="text-muted small">Aucun projet pour cette sélection.</div>';
    }

    function rafraichir() {
        const secteur = selSecteur.value;
        const zone = selZone.value;
        const actif = !!(secteur || zone);
        const liste = projets.filter(p =>
            (!secteur || String(p.secteur_id ?? '') === secteur) &&
            (!zone || p.zone_ids.includes(zone)));
        const total = stats(liste);

        // Résumé au-dessus de la carte : nombre de projets, montant, taux d'avancement
        resume.innerHTML =
            chip('bi-folder2-open', total.nb, 'projet(s)') +
            chip('bi-cash-coin', fmtMontant(total.montant), 'montant') +
            chip('bi-speedometer2', fmtPct(total.avancement), "taux d'avancement");

        afficherListe(liste, actif);

        // Carte : un rond par zone contenant des projets sélectionnés
        couche.clearLayers();
        const points = [];
        zones.forEach(z => {
            const liste_zone = liste.filter(p => p.zone_ids.includes(String(z.id)));
            if (!liste_zone.length) return;
            marqueurZone(z, liste_zone).addTo(couche);
            points.push([z.lat, z.lng]);
        });

        if (!actif || !points.length) {
            map.setView([7.5399, -5.5471], 6.5);
        } else if (points.length === 1) {
            map.flyTo(points[0], 9);
        } else {
            map.flyToBounds(points, { padding: [40, 40] });
        }
    }

    // Choisir un secteur et/ou une zone met à jour la carte et la liste des projets.
    [selSecteur, selZone].forEach(sel => sel.addEventListener('change', () => {
        rafraichir();
        if (selSecteur.value || selZone.value) {
            document.getElementById('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }));
    rafraichir();
</script>
@endpush
