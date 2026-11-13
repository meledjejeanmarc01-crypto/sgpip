{{-- Page d'aperçu avant impression d'un rapport : feuille A4 complète, sans menu, avec les boutons Imprimer et Fermer.
     Utilisée par rapports/show quand l'adresse contient ?imprimer=1 (icône imprimante de la liste des rapports). --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Rapport') · Aperçu avant impression · SGSPIP</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('partials.impression')
    <style>
        body { background: #E5E7EB; font-family: 'Inter', 'Segoe UI', Arial, sans-serif; color: #111827; }
        .btn-brand { background: #FF8200; border-color: #FF8200; color: #fff; }
        .btn-brand:hover { background: #E06E00; border-color: #E06E00; color: #fff; }
        .barre-apercu {
            position: sticky; top: 0; z-index: 10; background: #fff; border-bottom: 1px solid #D1D5DB;
            padding: 10px 18px; display: flex; justify-content: space-between; align-items: center; gap: 12px;
        }
        .feuille {
            background: #fff; width: 210mm; max-width: 100%; min-height: 297mm;
            margin: 18px auto 40px; padding: 15mm 14mm; box-shadow: 0 2px 14px rgba(0, 0, 0, .18);
        }
        @media print {
            body { background: #fff !important; }
            .barre-apercu { display: none !important; }
            .feuille { width: auto; max-width: none; min-height: 0; margin: 0; padding: 0; box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="barre-apercu no-print">
        <div class="fw-semibold"><i class="bi bi-eye me-1"></i> Aperçu avant impression</div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-brand" onclick="window.print()"><i class="bi bi-printer"></i> Imprimer</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.close()"><i class="bi bi-x-lg"></i> Fermer</button>
        </div>
    </div>

    <div class="feuille">
        {{-- En-tête officiel, visible à l'écran comme à l'impression --}}
        @include('partials.entete_document', ['visibleEcran' => true])

        @yield('content')
    </div>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
