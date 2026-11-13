@extends('layouts.app')
@section('page-title', 'Projets')

@push('styles')
<style>
    /* Palette nationale : orange · blanc · vert */
    .projets-page { --orange:#F4992A; --orange-dark:#D9811A; --vert:#009A44; --vert-dark:#007A37; }
    .flag-strip { height:6px; border-radius:999px; background:linear-gradient(90deg,var(--orange) 0 33.33%,#fff 33.33% 66.66%,var(--vert) 66.66% 100%); }

    /* Bandeau photo : l'image est entièrement visible, teintée orange à gauche et vert à droite */
    .projets-hero {
        position:relative; overflow:hidden; border-radius:1.2rem; margin-bottom:1.1rem;
        min-height:210px; padding:1.5rem 1.8rem; display:flex; align-items:flex-end; justify-content:space-between; gap:1rem; flex-wrap:wrap;
        background:
            linear-gradient(0deg, rgba(0,0,0,.50) 0%, rgba(0,0,0,0) 62%),
            linear-gradient(90deg, rgba(244,153,42,.74) 0%, rgba(244,153,42,.12) 36%, rgba(0,154,68,.12) 64%, rgba(0,122,55,.72) 100%),
            url('{{ asset('images/photo-abidjan-fond.jpg') }}') center 15% / cover no-repeat;
        box-shadow:0 16px 40px rgba(15,23,42,.25);
    }
    .projets-hero .flag-strip { width:120px; margin-bottom:.8rem; box-shadow:0 1px 6px rgba(0,0,0,.35); }
    .projets-titre { color:#fff; font-size:1.55rem; margin:0; text-shadow:0 2px 14px rgba(0,0,0,.55); }
    .projets-hero .btn-nouveau { background:#fff; color:var(--orange-dark); font-weight:600; border:0; box-shadow:0 8px 22px rgba(0,0,0,.30); }
    .projets-hero .btn-nouveau:hover { background:var(--orange); color:#fff; }

    /* Cartes blanches nettes (filtres et tableau) */
    .projets-page .card-stat { border:0; border-radius:1.1rem; box-shadow:0 10px 30px rgba(15,23,42,.10); overflow:hidden; }
    .projets-page .form-control:focus, .projets-page .form-select:focus { border-color:var(--orange); box-shadow:0 0 0 .2rem rgba(244,153,42,.18); }
    .projets-page .btn-recherche { background:linear-gradient(135deg,var(--orange),var(--orange-dark)); color:#fff; border:0; }

    /* Tableau */
    .projets-table thead th { background:linear-gradient(135deg,var(--orange),var(--orange-dark)); color:#fff; font-size:.76rem; text-transform:uppercase; letter-spacing:.05em; border:0; padding:.9rem .8rem; white-space:nowrap; }
    .projets-table tbody td { padding:.85rem .8rem; border-color:rgba(15,23,42,.06); }
    .projets-table tbody tr:nth-child(even) { background:rgba(0,154,68,.05); }
    .projets-table tbody tr:hover { background:rgba(244,153,42,.12); }
    /* Liseré tricolore (orange · blanc · vert) à gauche de chaque ligne, sans décaler les colonnes */
    .projets-table tbody td:first-child {
        background-image:linear-gradient(180deg,var(--orange) 0 33.33%,#fff 33.33% 66.66%,var(--vert) 66.66% 100%);
        background-size:5px 100%; background-repeat:no-repeat; background-position:left top;
    }
    .projets-table a.titre { color:#1F2937; }
    .projets-table a.titre:hover { color:var(--orange-dark); }
    .projets-table .cout { color:var(--vert-dark); }

    /* Statuts : pastilles pleines, bien lisibles */
    .projets-page .badge { border-radius:999px; padding:.45em .85em; font-size:.74rem; font-weight:600; text-transform:capitalize; }
    .projets-page .badge-statut-planifie { background:#fff; color:#4B5563; border:1px solid #D1D5DB; }
    .projets-page .badge-statut-en_cours { background:var(--orange); color:#fff; }
    .projets-page .badge-statut-termine { background:var(--vert); color:#fff; }
    .projets-page .badge-statut-suspendu { background:#fff; color:var(--orange-dark); border:1px solid var(--orange); }
    .projets-page .badge-statut-retarde { background:#BF7014; color:#fff; }

    /* Avancement */
    .projets-page .progress { background:rgba(15,23,42,.10); border-radius:999px; height:9px !important; }
    .projets-page .progress-bar { border-radius:999px; background:linear-gradient(90deg,var(--orange),var(--vert)) !important; }

    /* Boutons d'action */
    .projets-page .act-voir { border-color:var(--vert); color:var(--vert); background:#fff; } .projets-page .act-voir:hover { background:var(--vert); color:#fff; }
    .projets-page .act-modif { border-color:var(--orange); color:var(--orange-dark); background:#fff; } .projets-page .act-modif:hover { background:var(--orange); color:#fff; }

    /* Pagination */
    .projets-page .pagination .page-item.active .page-link { background:linear-gradient(135deg,var(--orange),var(--orange-dark)); color:#fff; }
</style>
@endpush
@section('content')
<div class="projets-page">
<div class="projets-hero">
    <div>
        <div class="flag-strip"></div>
        <h5 class="fw-bold projets-titre">Projets d'investissement public</h5>
    </div>
    @if(auth()->user()->peutModifier('projets'))
        <a href="{{ route('projets.create') }}" class="btn btn-nouveau"><i class="bi bi-plus-lg"></i> Nouveau projet</a>
    @endif
</div>

<form class="card card-stat p-3 mb-3">
    <div class="row g-2">
        <div class="col-md-3"><input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Référence ou intitulé..."></div>
        <div class="col-md-2">
            <select name="secteur_id" class="form-select form-select-sm">
                <option value="">Tous les secteurs</option>
                @foreach($secteurs as $s)<option value="{{ $s->id }}" @selected(request('secteur_id')==$s->id)>{{ $s->libelle }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="structure_id" class="form-select form-select-sm">
                <option value="">Toutes les structures</option>
                @foreach($structures as $s)<option value="{{ $s->id }}" @selected(request('structure_id')==$s->id)>{{ $s->sigle ?? $s->libelle }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="zone_execution_id" class="form-select form-select-sm">
                <option value="">Toutes les zones</option>
                @foreach($zones as $z)<option value="{{ $z->id }}" @selected(request('zone_execution_id')==$z->id)>{{ $z->libelle }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="statut" class="form-select form-select-sm">
                <option value="">Tous les statuts</option>
                @foreach(['planifie'=>'Planifié','en_cours'=>'En cours','termine'=>'Terminé','suspendu'=>'Suspendu','retarde'=>'Retardé'] as $val=>$label)
                    <option value="{{ $val }}" @selected(request('statut')==$val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1"><button class="btn btn-sm btn-recherche w-100"><i class="bi bi-search"></i></button></div>
    </div>
</form>

<div class="card card-stat">
    <div class="flag-strip"></div>
    <div class="table-responsive">
        <table class="table projets-table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Intitulé</th>
                    <th>Structure</th>
                    <th>Secteur</th>
                    <th>Zone(s)</th>
                    <th>Statut</th>
                    <th>Avancement</th>
                    <th>Coût estimatif</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projets as $projet)
                <tr>
                    <td class="text-muted small">{{ $projet->reference }}</td>
                    <td>
                        <a href="{{ route('projets.show', $projet) }}" class="titre text-decoration-none fw-semibold">{{ $projet->intitule }}</a>
                    </td>
                    <td class="small">{{ $projet->structure->libelle ?? '—' }}</td>
                    <td class="small">{{ $projet->secteur->libelle ?? '—' }}</td>
                    <td class="small">{{ $projet->zonesExecution->pluck('libelle')->join(', ') ?: '—' }}</td>
                    <td><span class="badge badge-statut-{{ $projet->statut }}">{{ str_replace('_',' ',$projet->statut) }}</span></td>
                    <td style="min-width:120px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height:6px;"><div class="progress-bar bg-success" style="width: {{ $projet->avancement_physique }}%"></div></div>
                            <span class="small text-muted">{{ $projet->avancement_physique }}%</span>
                        </div>
                    </td>
                    <td class="small fw-semibold cout">{{ number_format($projet->cout_estimatif,0,',',' ') }} FCFA</td>
                    <td class="text-end">
                        <a href="{{ route('projets.show', $projet) }}" class="btn btn-sm btn-outline-secondary act-voir"><i class="bi bi-eye"></i></a>
                        @if(auth()->user()->peutModifierProjet($projet))
                            <a href="{{ route('projets.edit', $projet) }}" class="btn btn-sm btn-outline-secondary act-modif"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('projets.destroy', $projet) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Aucun projet ne correspond aux critères.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $projets->links() }}</div>
</div>
@endsection
