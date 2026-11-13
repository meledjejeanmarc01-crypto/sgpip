@extends('layouts.app')

@section('title', 'Carte du territoire - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-1"><i class="bi bi-geo-alt"></i> Carte du territoire</h2>
        <p class="text-muted mb-0">Cliquez sur un rond pour afficher, dans la liste à côté, les projets de la zone correspondante.</p>
    </div>

    <div class="row g-3">
        {{-- Carte : uniquement les ronds des zones, aucun projet n'est dessiné dessus --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div id="carte" style="height: 650px; border-radius: 10px; overflow: hidden;"></div>
                </div>
            </div>
        </div>

        {{-- Liste des projets --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column" style="max-height: 650px;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="fw-bold mb-0">Projets <span class="badge" style="background:#F4992A" id="liste-nb">0</span></h5>
                            <div class="small text-muted" id="liste-sous-titre">Tous les projets</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="liste-reset"><i class="bi bi-x-lg me-1"></i>Tout afficher</button>
                    </div>
                    <div class="small text-muted mb-2" id="liste-resume"></div>
                    <input type="search" class="form-control form-control-sm mb-2" id="liste-recherche" placeholder="Rechercher un projet...">
                    <div id="liste-projets" class="flex-grow-1" style="overflow-y: auto;"></div>
                </div>
            </div>
        </div>
    </div>

    @if($zonesCarteData->isEmpty())
        <div class="alert alert-warning mt-3">
            <i class="bi bi-exclamation-triangle"></i>
            Aucune zone géolocalisée pour le moment. Pour qu'un rond apparaisse sur la carte, il faut :
            <ol class="mb-0 mt-2">
                <li>Renseigner les coordonnées GPS d'une <strong>zone d'exécution</strong> dans
                    <a href="{{ route('zones.index') }}">Zones d'exécution</a> ;</li>
                <li>Puis rattacher un projet à cette zone d'exécution (sur la fiche du projet, en modification).</li>
            </ol>
        </div>
    @endif

</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
    <style>
        .projet-ligne { border: 1px solid #eef0f3; border-radius: .8rem; padding: .6rem .8rem; margin-bottom: .5rem; background: #fff; }
        .projet-ligne:hover { border-color: #F4992A; }
        .projet-ligne .progress { height: 6px; }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    <script>
        const map = L.map('carte').setView([7.539989, -5.54708], 7); // centre approximatif de la Côte d'Ivoire
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(map);

        const zones = @json($zonesCarteData);
        const projets = @json($projetsIndex);

        const fmtMontant = v => new Intl.NumberFormat('fr-FR').format(Math.round(v)) + ' FCFA';
        const fmtPct = v => (Math.round(v * 10) / 10).toString().replace('.', ',') + '%';
        const libStatut = s => { const t = String(s ?? '').replace(/_/g, ' '); return t.charAt(0).toUpperCase() + t.slice(1); };
        const couleurStatut = { planifie: 'bg-secondary', en_cours: 'bg-primary', termine: 'bg-success', suspendu: 'bg-warning text-dark', retarde: 'bg-danger' };
        const esc = t => String(t ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

        const elListe = document.getElementById('liste-projets');
        const elNb = document.getElementById('liste-nb');
        const elSousTitre = document.getElementById('liste-sous-titre');
        const elResume = document.getElementById('liste-resume');
        const elReset = document.getElementById('liste-reset');
        const elRecherche = document.getElementById('liste-recherche');

        let zoneActive = null;     // id de la zone sélectionnée (string) ou null
        const marqueurs = {};      // id de zone -> marqueur

        // Rond d'une zone : même présentation que sur le tableau de bord (taille = nombre de projets, anneau = avancement).
        function icone(z, selectionne) {
            const d = 30 + Math.min(z.nb, 10) * 4;
            const r = d / 2 - 4;
            const c = 2 * Math.PI * r;
            const avancement = Math.max(0, Math.min(z.avancement, 100));
            const dash = c * avancement / 100;
            const trait = selectionne ? '#F4992A' : '#009A44';
            const fond = selectionne ? '#FEF5E7' : '#fff';
            return L.divIcon({
                className: '',
                iconSize: [d, d],
                iconAnchor: [d / 2, d / 2],
                html: `
                    <svg width="${d}" height="${d}" viewBox="0 0 ${d} ${d}">
                        <circle cx="${d/2}" cy="${d/2}" r="${r}" fill="${fond}" stroke="#E7E9EC" stroke-width="4"/>
                        <circle cx="${d/2}" cy="${d/2}" r="${r}" fill="none" stroke="${trait}" stroke-width="4"
                            stroke-dasharray="${dash.toFixed(1)} ${c.toFixed(1)}" stroke-linecap="round"
                            transform="rotate(-90 ${d/2} ${d/2})"/>
                        <text x="${d/2}" y="${d/2 + d*0.07}" text-anchor="middle" font-size="${d*0.26}" font-weight="700" fill="#1C2024">${Math.round(avancement)}%</text>
                    </svg>`
            });
        }

        function stats(liste) {
            const nb = liste.length;
            const montant = liste.reduce((t, p) => t + p.cout, 0);
            const avancement = nb ? liste.reduce((t, p) => t + p.avancement, 0) / nb : 0;
            return { nb, montant, avancement };
        }

        function afficherListe() {
            const terme = elRecherche.value.trim().toLowerCase();
            let liste = projets.filter(p => !zoneActive || p.zone_ids.includes(zoneActive));
            const zone = zoneActive ? zones.find(z => String(z.id) === zoneActive) : null;
            if (terme) {
                liste = liste.filter(p => (p.intitule + ' ' + p.reference + ' ' + p.zones).toLowerCase().includes(terme));
            }
            const s = stats(liste);

            elNb.textContent = liste.length;
            elSousTitre.textContent = zone ? 'Zone : ' + zone.libelle + ' (' + zone.type + ')' : 'Tous les projets';
            elReset.classList.toggle('d-none', !zoneActive);
            elResume.textContent = liste.length
                ? fmtMontant(s.montant) + ' · avancement moyen ' + fmtPct(s.avancement)
                : '';

            elListe.innerHTML = liste.length ? liste.map(p => `
                <div class="projet-ligne">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <a href="${esc(p.url)}" class="fw-semibold text-decoration-none small">${esc(p.intitule)}</a>
                        <span class="badge ${couleurStatut[p.statut] ?? 'bg-secondary'}">${esc(libStatut(p.statut))}</span>
                    </div>
                    <div class="small text-muted">${esc(p.reference)}${p.zones ? ' · ' + esc(p.zones) : ''}</div>
                    <div class="small mt-1"><i class="bi bi-cash-coin me-1"></i>${fmtMontant(p.cout)}</div>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <div class="progress flex-grow-1"><div class="progress-bar" style="width:${Math.max(0, Math.min(p.avancement, 100))}%; background:#009A44"></div></div>
                        <span class="small text-muted">${fmtPct(p.avancement)}</span>
                    </div>
                </div>`).join('') : '<div class="text-muted small">Aucun projet pour cette sélection.</div>';
        }

        function selectionner(id) {
            const nouvelle = (zoneActive === String(id)) ? null : String(id);   // un second clic désélectionne
            if (zoneActive && marqueurs[zoneActive]) {
                marqueurs[zoneActive].setIcon(icone(zones.find(z => String(z.id) === zoneActive), false));
            }
            zoneActive = nouvelle;
            if (zoneActive) {
                marqueurs[zoneActive].setIcon(icone(zones.find(z => String(z.id) === zoneActive), true));
            }
            afficherListe();
        }

        const bounds = [];
        zones.forEach(function (z) {
            const m = L.marker([z.lat, z.lng], { icon: icone(z, false), title: z.libelle + ' : ' + z.nb + ' projet(s)' }).addTo(map);
            m.on('click', () => selectionner(z.id));
            marqueurs[String(z.id)] = m;
            bounds.push([z.lat, z.lng]);
        });

        if (bounds.length === 1) {
            map.setView(bounds[0], 10);
        } else if (bounds.length > 1) {
            map.fitBounds(bounds, { padding: [40, 40] });
        }

        elReset.addEventListener('click', () => { if (zoneActive) { selectionner(zoneActive); } });
        elRecherche.addEventListener('input', afficherListe);
        afficherListe();

        // Recalcul de la taille de la carte une fois la page prête.
        window.addEventListener('load', function () { map.invalidateSize(); });
    </script>
@endpush

@endsection
