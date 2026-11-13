<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGSPIP')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sgspip-orange: #F4992A;
            --sgspip-orange-dark: #D9811A;
            --sgspip-orange-soft: #FEF4E4;
            --sgspip-vert: #009A44;
            --sgspip-vert-soft: #E6F6ED;
            --sgspip-blanc: #FFFFFF;
            --sgspip-ink: #1F2937;
            --sgspip-muted: #6B7280;
            --sgspip-border: #ECEFF2;
        }

        /* --- Thème national : tout Bootstrap en orange · blanc · vert --- */
        :root {
            --bs-primary: #F4992A;   --bs-primary-rgb: 244,153,42;
            --bs-warning: #F4992A;   --bs-warning-rgb: 244,153,42;
            --bs-success: #009A44;   --bs-success-rgb: 0,154,68;
            --bs-info:    #009A44;   --bs-info-rgb: 0,154,68;
            --bs-link-color: #D9811A; --bs-link-color-rgb: 224,110,0;
            --bs-link-hover-color: #007A37; --bs-link-hover-color-rgb: 0,122,55;
            --bs-focus-ring-color: rgba(244,153,42,.25);
        }
        .btn-primary, .btn-warning {
            --bs-btn-color: #fff; --bs-btn-bg: #F4992A; --bs-btn-border-color: #F4992A;
            --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #D9811A; --bs-btn-hover-border-color: #D9811A;
            --bs-btn-active-color: #fff; --bs-btn-active-bg: #BF7014; --bs-btn-active-border-color: #BF7014;
            --bs-btn-disabled-color: #fff; --bs-btn-disabled-bg: #F4992A; --bs-btn-disabled-border-color: #F4992A;
            --bs-btn-focus-shadow-rgb: 244,153,42;
        }
        .btn-outline-primary, .btn-outline-warning {
            --bs-btn-color: #D9811A; --bs-btn-border-color: #F4992A;
            --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #F4992A; --bs-btn-hover-border-color: #F4992A;
            --bs-btn-active-color: #fff; --bs-btn-active-bg: #D9811A; --bs-btn-active-border-color: #D9811A;
            --bs-btn-focus-shadow-rgb: 244,153,42;
        }
        .btn-success, .btn-info {
            --bs-btn-color: #fff; --bs-btn-bg: #009A44; --bs-btn-border-color: #009A44;
            --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #007A37; --bs-btn-hover-border-color: #007A37;
            --bs-btn-active-color: #fff; --bs-btn-active-bg: #006A30; --bs-btn-active-border-color: #006A30;
            --bs-btn-focus-shadow-rgb: 0,154,68;
        }
        .btn-outline-success, .btn-outline-info {
            --bs-btn-color: #007A37; --bs-btn-border-color: #009A44;
            --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #009A44; --bs-btn-hover-border-color: #009A44;
            --bs-btn-active-bg: #007A37; --bs-btn-active-border-color: #007A37;
            --bs-btn-focus-shadow-rgb: 0,154,68;
        }
        .bg-primary, .bg-warning { background-color: #F4992A !important; color: #fff !important; }
        .bg-info { background-color: #009A44 !important; color: #fff !important; }
        .text-primary, .text-warning { color: #D9811A !important; }
        .text-info { color: #007A37 !important; }
        .alert-info    { --bs-alert-bg: #E6F6ED; --bs-alert-border-color: #BFE7CF; --bs-alert-color: #006A30; }
        .alert-warning { --bs-alert-bg: #FEF4E4; --bs-alert-border-color: #F9D5A0; --bs-alert-color: #8A4300; }
        .form-check-input:checked { background-color: #F4992A; border-color: #F4992A; }
        .nav-tabs .nav-link.active, .nav-pills .nav-link.active { color: #D9811A; }
        .page-link { color: #D9811A; }

        body { background-color: #F6F7F9; color: var(--sgspip-ink); }

        /* --- Barre latérale --- */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--sgspip-orange) 0%, var(--sgspip-orange-dark) 100%);
            box-shadow: 2px 0 12px rgba(0,0,0,.08);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.88);
            font-size: .92rem;
            padding: .55rem .75rem;
            border-radius: .5rem;
            margin-bottom: .1rem;
            transition: background .15s ease, transform .1s ease;
        }
        .sidebar .nav-link:hover { background: rgba(255,255,255,.16); color: #fff; transform: translateX(2px); }
        .sidebar .nav-link.active { background: rgba(255,255,255,.24); color: #fff; font-weight: 600; box-shadow: inset 0 0 0 1px rgba(255,255,255,.25); }
        .sidebar .nav-header { color: rgba(255,255,255,.65); font-size: .7rem; text-transform: uppercase; letter-spacing: .07em; margin-top: 1.1rem; font-weight: 600; }

        /* --- Barre du haut --- */
        .navbar-top { border-bottom: 1px solid var(--sgspip-border); box-shadow: 0 1px 2px rgba(0,0,0,.03); }

        /* --- Cartes --- */
        .card-stat {
            border: 1px solid var(--sgspip-border);
            border-radius: .9rem;
            box-shadow: 0 2px 10px rgba(15,23,42,.04);
            transition: box-shadow .15s ease, transform .15s ease;
            background: #fff;
        }
        .card-stat:hover { box-shadow: 0 6px 18px rgba(15,23,42,.07); }
        a .card-stat:hover, .card-stat.card-hover:hover { transform: translateY(-2px); }

        /* --- Boutons --- */
        .btn-brand {
            background: var(--sgspip-orange);
            border: 1px solid var(--sgspip-orange);
            color: #fff;
            font-weight: 500;
            box-shadow: 0 1px 2px rgba(244,153,42,.25);
            transition: background .15s ease, box-shadow .15s ease;
        }
        .btn-brand:hover, .btn-brand:focus {
            background: var(--sgspip-orange-dark);
            border-color: var(--sgspip-orange-dark);
            color: #fff;
            box-shadow: 0 3px 10px rgba(244,153,42,.35);
        }
        .btn-outline-secondary, .btn-outline-danger { border-radius: .5rem; }
        .btn { border-radius: .5rem; }
        .btn-sm { border-radius: .45rem; }

        /* --- Badges de statut : version "pastille" plus douce --- */
        .badge { font-weight: 500; padding: .4em .7em; border-radius: 999px; }
        .badge-statut-en_cours    { background-color: var(--sgspip-orange-soft); color: #BF7014; }
        .badge-statut-termine     { background-color: var(--sgspip-vert-soft); color: #007A37; }
        .badge-statut-planifie    { background-color: #fff; color: #4B5563; border: 1px solid #D1D5DB; }
        .badge-statut-suspendu    { background-color: #fff; color: #BF7014; border: 1px solid var(--sgspip-orange); }
        .badge-statut-retarde     { background-color: #BF7014; color: #fff; }

        /* --- Tableaux --- */
        .table-responsive { border-radius: .65rem; overflow: hidden; border: 1px solid var(--sgspip-border); }
        .table { margin-bottom: 0; }
        .table thead.table-light th, .table thead th {
            background: #FAFBFC;
            color: var(--sgspip-muted);
            font-size: .76rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            font-weight: 600;
            border-bottom: 1px solid var(--sgspip-border);
        }
        .table tbody tr:hover { background: #FFFAF2; }
        .table td, .table th { vertical-align: middle; padding: .7rem .9rem; }

        .brand-title { font-weight: 700; letter-spacing: .03em; }

        /* --- Typographie --- */
        body, .form-control, .form-select, .btn { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; }
        h1, h2, h3, h4, h5, h6, .fw-bold { letter-spacing: -.01em; }
        main { animation: sgspip-fade .25s ease; flex: 1 1 auto; }

        /* Images de fond des pages (voile clair pour garder les cartes et textes lisibles) */
        main.bg-infra, main.bg-abidjan {
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            flex: 1 1 auto;
        }
        main.bg-infra {
            background-image: linear-gradient(rgba(246,247,249,.88), rgba(246,247,249,.88)), url('{{ asset('images/infrastructures-ivoiriennes-fond.jpg') }}');
        }
        main.bg-abidjan {
            background-attachment: scroll;   /* l'image suit la page : plus de décalage avec le contenu */
            background-position: center top;
            background-image: linear-gradient(135deg, rgba(244,153,42,.50) 0%, rgba(15,23,42,.30) 48%, rgba(0,154,68,.55) 100%), url('{{ asset('images/photo-abidjan-fond.jpg') }}');
        }
        @keyframes sgspip-fade { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: none; } }

        /* --- Formulaires --- */
        .form-control, .form-select {
            border-color: #DDE2E7;
            border-radius: .5rem;
            font-size: .9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--sgspip-orange);
            box-shadow: 0 0 0 .2rem rgba(244,153,42,.15);
        }
        .form-label { font-size: .84rem; font-weight: 600; color: #374151; margin-bottom: .3rem; }
        .input-group-text { background: #FAFBFC; border-color: #DDE2E7; }

        /* --- Modales --- */
        .modal-content { border: 0; border-radius: 1rem; box-shadow: 0 10px 40px rgba(15,23,42,.18); }
        .modal-header { border-bottom: 1px solid var(--sgspip-border); padding: 1.1rem 1.4rem; }
        .modal-header .modal-title { font-weight: 700; font-size: 1.02rem; }
        .modal-body { padding: 1.4rem; }
        .modal-footer { border-top: 1px solid var(--sgspip-border); padding: 1rem 1.4rem; }

        /* --- Alertes --- */
        .alert { border: 0; border-radius: .7rem; border-left: 4px solid transparent; }
        .alert-success { background: var(--sgspip-vert-soft); color: #0A5C2C; border-left-color: var(--sgspip-vert); }
        .alert-danger { background: #FDECEC; color: #A3221B; border-left-color: #DC3B32; }

        /* --- Pagination --- */
        .pagination .page-link { border: 0; color: #4B5563; margin: 0 .12rem; border-radius: .45rem; font-size: .86rem; }
        .pagination .page-item.active .page-link { background: var(--sgspip-orange); color: #fff; }
        .pagination .page-link:hover { background: var(--sgspip-orange-soft); color: var(--sgspip-orange-dark); }

        /* --- État vide --- */
        .empty-state { text-align: center; color: var(--sgspip-muted); padding: 3rem 1rem; }
        .empty-state i { font-size: 2.4rem; display: block; margin-bottom: .6rem; color: #D1D5DB; }

        /* --- Avatar utilisateur (barre du haut) --- */
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--sgspip-orange-soft); color: var(--sgspip-orange-dark);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .82rem;
        }
    </style>
    @include('partials.impression')
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <nav class="sidebar p-3" style="width: 260px; position: sticky; top:0;">
        <div class="d-flex align-items-center gap-2 mb-4 px-1">
            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px;height:50px; box-shadow: 0 3px 10px rgba(0,0,0,.22); border:2px solid rgba(255,255,255,.85);">
                <img src="{{ asset('images/armoiries-logo.png') }}" alt="Armoiries de la Côte d'Ivoire" style="width:36px;height:36px;object-fit:contain;">
            </div>
            <div>
                <div class="text-white brand-title">SGSPIP</div>
                <div class="text-white-50" style="font-size:.68rem;">Rép. de Côte d'Ivoire</div>
            </div>
        </div>
        @php
            // Menu : chaque entrée = [module (config/acces.php), motif de route actif, route, icône, libellé].
            // Une entrée n'apparaît que si le rôle de l'utilisateur peut voir son module ;
            // un groupe sans aucune entrée visible disparaît.
            $menuUtilisateur = auth()->user();
            $menuGroupes = [
                'Planification' => [
                    ['programmes', 'programmes.*', 'programmes.index', 'bi-diagram-3', 'Programmes'],
                    ['fiches-pip', 'fiches-pip.*', 'fiches-pip.index', 'bi-file-earmark-text', 'Fiches PIP'],
                    ['reformes', 'reformes.*', 'reformes.index', 'bi-arrow-repeat', 'Réformes'],
                ],
                'Projets' => [
                    ['projets', 'projets.*', 'projets.index', 'bi-kanban', 'Projets'],
                    ['projets', 'projets.carte', 'projets.carte', 'bi-geo-alt', 'Carte du territoire'],
                    ['secteurs', 'secteurs.*', 'secteurs.index', 'bi-grid', 'Secteurs'],
                    ['localisation', 'localisation.*', 'localisation.index', 'bi-map', 'Localisation géographique'],
                    ['zones', 'zones.*', 'zones.index', 'bi-geo-alt', "Zones d'exécution"],
                    ['pays-etrangers', 'pays-etrangers.*', 'pays-etrangers.index', 'bi-globe', 'Pays étrangers'],
                    ['actions-pnd', 'actions-pnd.*', 'actions-pnd.index', 'bi-signpost-2', 'Actions PND'],
                    ['documents', 'documents.*', 'documents.index', 'bi-file-earmark', 'Documents'],
                ],
                'Finances' => [
                    ['bailleurs', 'bailleurs.*', 'bailleurs.index', 'bi-bank', 'Bailleurs'],
                    ['financements', 'financements.*', 'financements.index', 'bi-cash-coin', 'Financements'],
                    ['conventions-financement', 'conventions-financement.*', 'conventions-financement.index', 'bi-file-earmark-check', 'Conventions'],
                    ['decaissements', 'decaissements.*', 'decaissements.index', 'bi-arrow-down-circle', 'Décaissements'],
                    ['depenses', 'depenses.*', 'depenses.index', 'bi-receipt', 'Dépenses'],
                    ['situation-financiere', 'situation-financiere.*', 'situation-financiere.index', 'bi-pie-chart', 'Situation financière'],
                ],
                'Suivi-évaluation' => [
                    ['rapports', 'rapports.*', 'rapports.index', 'bi-bar-chart-line', 'Rapports'],
                ],
                'Administration' => [
                    ['structures', 'structures.*', 'structures.index', 'bi-building', 'Structures'],
                    ['acteurs', 'acteurs.*', 'acteurs.index', 'bi-people', 'Acteurs'],
                    ['utilisateurs', 'utilisateurs.*', 'utilisateurs.index', 'bi-people', 'Utilisateurs'],
                ],
            ];
        @endphp
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a></li>

            @foreach($menuGroupes as $menuTitre => $menuLiens)
                @php $menuVisibles = array_filter($menuLiens, fn ($lien) => (bool) $menuUtilisateur?->peutVoir($lien[0])); @endphp
                @if(count($menuVisibles))
                    <div class="nav-header px-2">{{ $menuTitre }}</div>
                    @foreach($menuVisibles as $lien)
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs($lien[1]) ? 'active' : '' }}" href="{{ route($lien[2]) }}"><i class="bi {{ $lien[3] }} me-2"></i>{{ $lien[4] }}</a></li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>

    <div class="flex-fill d-flex flex-column" style="min-width:0;">
        <nav class="navbar navbar-top navbar-light bg-white px-4 py-2">
            <span class="navbar-text fw-semibold text-secondary">@yield('page-title', 'Tableau de bord')</span>
            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-secondary position-relative" title="Notifications">
                    <i class="bi bi-bell"></i>
                    @php $nonLues = auth()->user()?->unreadNotifications()->count() ?? 0; @endphp
                    @if($nonLues)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $nonLues }}</span>@endif
                </a>
                <a href="{{ route('mot-de-passe.edit') }}" class="btn btn-sm btn-outline-secondary" title="Modifier mon mot de passe"><i class="bi bi-key"></i></a>
                <span class="text-muted small text-end">
                    {{ auth()->user()?->prenom }} {{ auth()->user()?->nom }}<br>
                    <span class="badge bg-light text-dark border">{{ str_replace('_',' ',auth()->user()?->role) }}</span>
                </span>
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()?->prenom ?? 'U', 0, 1).substr(auth()->user()?->nom ?? '', 0, 1)) }}</div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Déconnexion</button>
                </form>
            </div>
        </nav>

        <main class="p-4 @yield('bg')">
            @hasSection('sans_entete')
            @else
                @include('partials.entete_document')
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@include('partials.types_creation')
@stack('scripts')
</body>
</html>
