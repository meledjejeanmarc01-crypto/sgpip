{{-- ============================================================================
     Impression : mise en page « document officiel » A4, commune à toutes les pages.
     - cache menu, barres, boutons, fenêtres modales
     - en-tête officiel (armoiries + bande orange · blanc · vert), voir partials/entete_document
     - pied de page numéroté (Chrome / Edge récents ; ignoré sans effet par les autres navigateurs)
     - la fiche projet imprime tous ses onglets, chacun précédé de son titre
     ============================================================================ --}}
<style>
    /* ---------- En-tête de document (visible à l'écran seulement si demandé) ---------- */
    .print-only, .print-pane-title { display: none; }
    .plh { margin-bottom: 14px; }
    .plh-top { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding-bottom: 9px; }
    .plh-left { display: flex; align-items: center; gap: 11px; }
    .plh-logo { width: 58px; height: 58px; object-fit: contain; }
    .plh-republique { font-family: Georgia, 'Times New Roman', serif; font-size: 13pt; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; color: #111827; line-height: 1.15; }
    .plh-devise { font-size: 8.5pt; font-style: italic; color: #6B7280; margin-top: 2px; }
    .plh-right { text-align: right; max-width: 52%; }
    .plh-ministere { font-size: 9.5pt; font-weight: 700; color: #1F2937; }
    .plh-systeme { font-size: 8pt; color: #6B7280; margin-top: 2px; line-height: 1.3; }
    .flag-band { display: flex; height: 6px; border-radius: 3px; overflow: hidden; }
    .flag-band span { flex: 1; }
    .flag-band span:nth-child(1) { background: #F4992A; }
    .flag-band span:nth-child(2) { background: #FFFFFF; box-shadow: inset 0 1px 0 #E5E7EB, inset 0 -1px 0 #E5E7EB; }
    .flag-band span:nth-child(3) { background: #009A44; }

    /* ---------- Page A4 et pied de page ---------- */
    @page {
        size: A4;
        margin: 15mm 14mm 20mm 14mm;
        @bottom-left {
            content: "SGSPIP · République de Côte d'Ivoire · Imprimé le {{ now()->format('d/m/Y à H:i') }}";
            font-family: Arial, Helvetica, sans-serif; font-size: 7.5pt; color: #6B7280;
            border-top: .5pt solid #D1D5DB; padding-top: 3mm; vertical-align: top;
        }
        @bottom-right {
            content: "Page " counter(page) " / " counter(pages);
            font-family: Arial, Helvetica, sans-serif; font-size: 7.5pt; color: #6B7280;
            border-top: .5pt solid #D1D5DB; padding-top: 3mm; vertical-align: top;
        }
    }

    @media print {
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }

        html, body { background: #fff !important; color: #111827 !important; }
        body { font-family: 'Inter', 'Segoe UI', Arial, sans-serif; font-size: 10.5pt; line-height: 1.5; }
        main { padding: 0 !important; background: none !important; }
        main::before, main::after { display: none !important; }

        /* Éléments d'interface : jamais imprimés */
        .sidebar, .navbar-top, .no-print, .btn, .alert, .modal, .modal-backdrop, .toast,
        .pagination, .nav-tabs, .nav-pills, .dropdown-menu, .form-text, .btn-close { display: none !important; }
        .print-only { display: block !important; }

        /* Cartes : sobres, sans ombre, jamais coupées en deux */
        .card, .card-stat { box-shadow: none !important; border: 1px solid #D9DEE5 !important; border-radius: 6px !important; break-inside: avoid; }
        .card.pp-card { break-inside: auto; }
        .card-body { padding: 10px 12px !important; }

        /* Titres : jamais isolés en bas de page */
        h1, h2, h3, h4, h5, h6 { break-after: avoid; color: #111827 !important; }

        /* Tableaux : en-têtes répétés à chaque page, lignes insécables */
        .table-responsive { overflow: visible !important; }
        table { width: 100% !important; border-collapse: collapse !important; font-size: 9pt; }
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
        tr, img { break-inside: avoid; }
        th { background: #F3F4F6 !important; color: #374151 !important; font-size: 7.5pt; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
        th, td { border: 1px solid #E1E5EA !important; padding: 4px 7px !important; vertical-align: top; }

        /* Liens : texte simple, sans soulignement ni URL */
        a, a:visited { color: inherit !important; text-decoration: none !important; }
        a[href]:after { content: "" !important; }

        /* Pastilles de statut : lisibles en noir et blanc comme en couleur */
        .badge { border: 1px solid #CBD2D9; font-weight: 600; }

        /* Onglets : tout est imprimé, chaque section avec son titre */
        .tab-content > .tab-pane { display: block !important; opacity: 1 !important; }
        .print-pane-title {
            display: block; margin: 20px 0 9px; padding: 5px 11px;
            font-size: 11pt; font-weight: 700; color: #fff; background: #009A44;
            border-left: 6px solid #F4992A; border-radius: 3px; break-after: avoid;
        }

        /* Fiche projet : grilles adaptées à la largeur A4 */
        .pp-grid { grid-template-columns: repeat(3, 1fr) !important; gap: 10px 16px !important; }
        .pp-texts { grid-template-columns: 1fr !important; }
        .pp-text, .pp-quarter, .pp-grid > div, .pp-section-title { break-inside: avoid; }
        .pp-section { break-inside: auto; }
        .pp-head { break-after: avoid; }
    }
</style>

<script>
    // Avant impression, chaque onglet reçoit son titre (celui du bouton d'onglet) ; retiré ensuite.
    (function () {
        function ajouterTitres() {
            document.querySelectorAll('.tab-content > .tab-pane').forEach(function (pane) {
                if (!pane.id || pane.querySelector(':scope > .print-pane-title')) { return; }
                var lien = document.querySelector('[data-bs-target="#' + pane.id + '"], a[href="#' + pane.id + '"]');
                if (!lien) { return; }
                var titre = document.createElement('div');
                titre.className = 'print-pane-title';
                titre.textContent = lien.textContent.trim();
                pane.insertBefore(titre, pane.firstChild);
            });
        }
        function retirerTitres() {
            document.querySelectorAll('.print-pane-title').forEach(function (el) { el.remove(); });
        }
        window.addEventListener('beforeprint', ajouterTitres);
        window.addEventListener('afterprint', retirerTitres);
    })();
</script>
