@extends('layouts.app')

@section('title', 'Localisation géographique - SGSPIP')

@section('content')
<style>
    /* Une couleur par niveau : la même dans la légende, le tableau et les filtres */
    .niv { display:inline-block; padding:.28rem .75rem; border-radius:999px; font-size:.78rem; font-weight:600; white-space:nowrap; }
    .niv-district        { background:#FCE3BF; color:#8A4300; }
    .niv-region          { background:#F4992A; color:#ffffff; }
    .niv-departement     { background:#E6F6ED; color:#007A37; }
    .niv-commune         { background:#009A44; color:#ffffff; }
    .niv-sous-prefecture { background:#ffffff; color:#BF7014; border:1px solid #F4992A; }
    .niv-village         { background:#ffffff; color:#007A37; border:1px solid #009A44; }

    .loc-card { border:0; border-radius:12px; box-shadow:0 1px 10px rgba(15,23,42,.07); overflow:hidden; }
    .loc-table thead th { font-size:.8rem; font-weight:600; color:#64748b; background:#f8fafc; border-bottom:1px solid #e2e8f0; padding:.85rem 1rem; white-space:nowrap; }
    .loc-table tbody td { padding:.85rem 1rem; border-color:#f1f5f9; }
    .loc-table tbody tr:hover { background:#f8fafc; }
    .loc-parent { font-size:.8rem; color:#94a3b8; }
    .loc-count { min-width:2.2rem; display:inline-block; text-align:center; padding:.2rem .5rem; border-radius:8px; background:#f1f5f9; font-weight:600; font-size:.85rem; color:#334155; }
    .loc-zone { color:#15803d; font-weight:500; font-size:.9rem; }
    .loc-zone-none { color:#cbd5e1; }
    .loc-legend { display:flex; flex-wrap:wrap; align-items:center; gap:.4rem; }
    .loc-legend .sep { color:#cbd5e1; }

    /* Sur ordinateur, les actions apparaissent au survol ; sur tactile elles restent visibles */
    @media (hover:hover) {
        .loc-actions { opacity:0; transition:opacity .15s; }
        .loc-table tbody tr:hover .loc-actions, .loc-actions:focus-within { opacity:1; }
    }
</style>

<div class="container-fluid py-4">

    <div class="mb-4">
        <h3 class="fw-bold mb-1"><i class="bi bi-map me-2"></i>Localisation géographique</h3>
        <p class="text-muted mb-3">
            Chaque localisation a un niveau et se rattache à celle du niveau juste au-dessus (sauf les districts).
            Les zones d'exécution des projets se gèrent sur la page <a href="{{ route('zones.index') }}">Zones d'exécution</a>.
        </p>
        <div class="loc-legend">
            <span class="niv niv-district">District</span><span class="sep">›</span>
            <span class="niv niv-region">Région</span><span class="sep">›</span>
            <span class="niv niv-departement">Département</span><span class="sep">›</span>
            <span class="niv niv-commune">Commune</span><span class="sep">›</span>
            <span class="niv niv-sous-prefecture">Sous-préfecture</span><span class="sep">›</span>
            <span class="niv niv-village">Village</span>
        </div>
    </div>

    <div class="card loc-card mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <span class="fw-semibold"><i class="bi bi-signpost-2 me-1"></i> Localisations</span>
            @if(auth()->user()->peutModifier('localisation'))
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalLocalisation"><i class="bi bi-plus-lg"></i> Ajouter</button>
            @endif
        </div>

        <div class="card-body border-bottom bg-white">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher par libellé">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <select name="niveau_id" class="form-select form-select-sm">
                        <option value="">Tous les niveaux</option>
                        @foreach($niveaux as $n)
                            <option value="{{ $n->id }}" @selected(request('niveau_id') == $n->id)>{{ $n->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-auto d-flex gap-2">
                    <button class="btn btn-sm btn-primary">Filtrer</button>
                    <a href="{{ route('localisation.index') }}" class="btn btn-sm btn-outline-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            @if($localisations->count())
                <div class="table-responsive">
                    <table class="table loc-table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Libellé</th>
                                <th>Niveau</th>
                                <th class="text-center">Localisations rattachées</th>
                                <th>Zone d'exécution</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($localisations as $l)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $l->libelle }}</div>
                                    <div class="loc-parent">
                                        @if($l->parent_immediat)
                                            <i class="bi bi-arrow-return-right"></i> {{ $l->parent_immediat->libelle }}
                                        @else
                                            Niveau le plus haut
                                        @endif
                                    </div>
                                </td>
                                <td><span class="niv niv-{{ Str::slug($l->niveau->libelle) }}">{{ $l->niveau->libelle }}</span></td>
                                <td class="text-center">
                                    @php $nb = $l->nombreEnfants(); @endphp
                                    <span class="loc-count {{ $nb ? '' : 'text-muted' }}">{{ $nb }}</span>
                                </td>
                                <td>
                                    @if($l->zoneExecution)
                                        <span class="loc-zone"><i class="bi bi-check-circle-fill"></i> {{ $l->zoneExecution->libelle }}</span>
                                    @else
                                        <span class="loc-zone-none">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if(auth()->user()->peutModifier('localisation'))
                                    <form class="loc-actions d-inline" action="{{ route('localisation.destroy', $l) }}" method="POST" onsubmit="return confirm('Supprimer cette localisation ?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-geo-alt fs-1 d-block mb-2"></i>
                    Aucune localisation trouvée. Modifiez le filtre ou ajoutez-en une.
                </div>
            @endif
        </div>
    </div>

    <div>{{ $localisations->links() }}</div>
</div>

{{-- MODALE : NOUVELLE LOCALISATION --}}
<div class="modal fade" id="modalLocalisation" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('localisation.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvelle localisation</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Niveau</label>
                        <select name="niveau_id" id="loc-niveau" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($niveaux as $n)
                                <option value="{{ $n->id }}" @selected(old('niveau_id') == $n->id)>{{ $n->libelle }}</option>
                            @endforeach
                        </select>
                        @error('niveau_id')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2" id="loc-parent-bloc">
                        <label class="form-label">Rattaché à</label>
                        <select name="parent_id" id="loc-parent" class="form-select">
                            <option value="">-- Choisir un niveau d'abord --</option>
                        </select>
                        @error('parent_id')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Libellé</label>
                        <input type="text" name="libelle" value="{{ old('libelle') }}" class="form-control" required>
                        @error('libelle')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Code (facultatif)</label>
                        <input type="text" name="code" value="{{ old('code') }}" class="form-control">
                        @error('code')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="0.0000001" name="latitude" value="{{ old('latitude') }}" class="form-control" placeholder="Ex : 5.359951">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="0.0000001" name="longitude" value="{{ old('longitude') }}" class="form-control" placeholder="Ex : -3.981817">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Milieu</label>
                        <select name="milieu" class="form-select">
                            <option value="">-- Non précisé --</option>
                            <option value="urbain" @selected(old('milieu') == 'urbain')>Urbain</option>
                            <option value="rural" @selected(old('milieu') == 'rural')>Rural</option>
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const niveauIds = @json($niveaux->pluck('id')->values());
    const niveau = document.getElementById('loc-niveau');
    const bloc = document.getElementById('loc-parent-bloc');
    const parent = document.getElementById('loc-parent');
    const base = @json(url('/localisation/niveaux'));

    async function chargerParents() {
        parent.innerHTML = '';
        const idx = niveauIds.indexOf(parseInt(niveau.value, 10));

        if (idx === -1) {                       // aucun niveau choisi
            bloc.style.display = '';
            parent.add(new Option("-- Choisir un niveau d'abord --", ''));
            return;
        }
        if (idx === 0) {                        // District : pas de parent (RG45)
            bloc.style.display = 'none';
            return;
        }

        bloc.style.display = '';
        const res = await fetch(`${base}/${niveauIds[idx - 1]}/localisations`, { headers: { 'Accept': 'application/json' } });
        const liste = await res.json();
        parent.add(new Option('-- Sélectionner --', ''));
        liste.forEach(l => parent.add(new Option(l.label, l.id)));
    }

    niveau.addEventListener('change', chargerParents);
    chargerParents();

    @if($errors->any())
        new bootstrap.Modal(document.getElementById('modalLocalisation')).show();
    @endif
})();
</script>
@endpush
