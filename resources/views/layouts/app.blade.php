<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGSPIP')</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.min.css') }}">
    <style>
        :root {
            --sgspip-orange: #FF8200;
            --sgspip-vert: #009A44;
            --sgspip-blanc: #FFFFFF;
        }
        body { background-color: #f4f6f8; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #ff8200 0%, #e67300 100%);
        }
        .sidebar .nav-link { color: rgba(255,255,255,.9); font-size: .92rem; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background: rgba(255,255,255,.18); color: #fff; border-radius: .4rem; }
        .sidebar .nav-header { color: rgba(255,255,255,.65); font-size: .72rem; text-transform: uppercase; letter-spacing: .05em; margin-top: 1rem; }
        .navbar-top { border-bottom: 3px solid var(--sgspip-vert); }
        .card-stat { border: none; border-radius: .75rem; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
        .badge-statut-en_cours { background-color: #0d6efd; }
        .badge-statut-termine { background-color: #009A44; }
        .badge-statut-planifie { background-color: #6c757d; }
        .badge-statut-suspendu { background-color: #ffc107; color:#212529; }
        .badge-statut-retarde { background-color: #dc3545; }
        .table-responsive { border-radius: .5rem; overflow: hidden; }
        .brand-title { font-weight: 700; letter-spacing: .03em; }

        /* Impression : n'afficher que le contenu principal, sans menu ni barre du haut */
        @media print {
            .sidebar, .navbar-top, .no-print { display: none !important; }
            main { padding: 0 !important; }
            body { background: #fff !important; }
            .card-stat { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
            a[href]:after { content: "" !important; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <nav class="sidebar p-3" style="width: 260px; position: sticky; top:0;">
        <div class="d-flex align-items-center gap-2 mb-4 px-1">
            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width:42px;height:42px;">
                <span class="fw-bold" style="color: var(--sgspip-orange);">CI</span>
            </div>
            <div>
                <div class="text-white brand-title">SGSPIP</div>
                <div class="text-white-50" style="font-size:.68rem;">Rép. de Côte d'Ivoire</div>
            </div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a></li>

            <div class="nav-header px-2">Planification</div>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('programmes.*') ? 'active' : '' }}" href="{{ route('programmes.index') }}"><i class="bi bi-diagram-3 me-2"></i>Programmes</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('fiches-pip.*') ? 'active' : '' }}" href="{{ route('fiches-pip.index') }}"><i class="bi bi-file-earmark-text me-2"></i>Fiches PIP</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('reformes.*') ? 'active' : '' }}" href="{{ route('reformes.index') }}"><i class="bi bi-arrow-repeat me-2"></i>Réformes</a></li>

            <div class="nav-header px-2">Projets</div>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('projets.*') ? 'active' : '' }}" href="{{ route('projets.index') }}"><i class="bi bi-kanban me-2"></i>Projets</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('secteurs.*') ? 'active' : '' }}" href="{{ route('secteurs.index') }}"><i class="bi bi-grid me-2"></i>Secteurs</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('zones.*') ? 'active' : '' }}" href="{{ route('zones.index') }}"><i class="bi bi-geo-alt me-2"></i>Zones & Carte</a></li>

            <div class="nav-header px-2">Finances</div>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('bailleurs.*') ? 'active' : '' }}" href="{{ route('bailleurs.index') }}"><i class="bi bi-bank me-2"></i>Bailleurs</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('financements.*') ? 'active' : '' }}" href="{{ route('financements.index') }}"><i class="bi bi-cash-coin me-2"></i>Financements</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('decaissements.*') ? 'active' : '' }}" href="{{ route('decaissements.index') }}"><i class="bi bi-arrow-down-circle me-2"></i>Décaissements</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('depenses.*') ? 'active' : '' }}" href="{{ route('depenses.index') }}"><i class="bi bi-receipt me-2"></i>Dépenses</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('etats.*') ? 'active' : '' }}" href="{{ route('etats.index') }}"><i class="bi bi-flag me-2"></i>État (financeur)</a></li>

            <div class="nav-header px-2">Suivi-évaluation</div>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('rapports.*') ? 'active' : '' }}" href="{{ route('rapports.index') }}"><i class="bi bi-bar-chart-line me-2"></i>Rapports</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('pieces-justificatives.*') ? 'active' : '' }}" href="{{ route('pieces-justificatives.index') }}"><i class="bi bi-paperclip me-2"></i>Pièces justificatives</a></li>

            <div class="nav-header px-2">Administration</div>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('structures.*') ? 'active' : '' }}" href="{{ route('structures.index') }}"><i class="bi bi-building me-2"></i>Structures</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('types-structure.*') ? 'active' : '' }}" href="{{ route('types-structure.index') }}"><i class="bi bi-tags me-2"></i>Types de structure</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('types-bailleur.*') ? 'active' : '' }}" href="{{ route('types-bailleur.index') }}"><i class="bi bi-tags me-2"></i>Types de bailleur</a></li>
            @if(auth()->user()?->isAdministrateur())
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}" href="{{ route('utilisateurs.index') }}"><i class="bi bi-people me-2"></i>Utilisateurs</a></li>
            @endif
        </ul>
    </nav>

    <div class="flex-fill">
        <nav class="navbar navbar-top navbar-light bg-white px-4 py-2">
            <span class="navbar-text fw-semibold text-secondary">@yield('page-title', 'Tableau de bord')</span>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-muted small">{{ auth()->user()?->prenom }} {{ auth()->user()?->nom }} · <span class="badge bg-light text-dark border">{{ str_replace('_',' ',auth()->user()?->role) }}</span></span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Déconnexion</button>
                </form>
            </div>
        </nav>

        <main class="p-4">
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
@stack('scripts')
</body>
</html>
