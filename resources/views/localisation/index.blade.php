@extends('layouts.app')

@section('title', 'Localisation géographique - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-1"><i class="bi bi-map"></i> Localisation géographique</h2>
        <p class="text-muted mb-0">
            Gérez la hiérarchie District → Région → Département → Commune → Localité.
            Seules les <strong>localités</strong> disposant de coordonnées GPS apparaissent sur la
            <a href="{{ route('projets.carte') }}">carte du territoire</a>.
        </p>
    </div>

    {{-- DISTRICTS --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="bi bi-flag"></i> Districts</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalDistrict"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div class="card-body p-0">
            @if($districts->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Nom</th><th>Régions</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @foreach($districts as $district)
                        <tr>
                            <td>{{ $district->nom }}</td>
                            <td>{{ $district->regions_count }}</td>
                            <td class="text-end">
                                <form action="{{ route('localisation.districts.destroy', $district) }}" method="POST" onsubmit="return confirm('Supprimer ce district ainsi que tout ce qui en dépend ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-3 mb-0">Aucun district enregistré.</p>
            @endif
        </div>
    </div>

    {{-- REGIONS --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="bi bi-signpost"></i> Régions</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegion"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div class="card-body p-0">
            @if($regions->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Nom</th><th>District</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @foreach($regions as $region)
                        <tr>
                            <td>{{ $region->nom }}</td>
                            <td>{{ $region->district?->nom ?? '—' }}</td>
                            <td class="text-end">
                                <form action="{{ route('localisation.regions.destroy', $region) }}" method="POST" onsubmit="return confirm('Supprimer cette région ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-3 mb-0">Aucune région enregistrée.</p>
            @endif
        </div>
    </div>

    {{-- DEPARTEMENTS --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="bi bi-signpost-2"></i> Départements</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalDepartement"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div class="card-body p-0">
            @if($departements->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Nom</th><th>Région</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @foreach($departements as $departement)
                        <tr>
                            <td>{{ $departement->nom }}</td>
                            <td>{{ $departement->region?->nom ?? '—' }}</td>
                            <td class="text-end">
                                <form action="{{ route('localisation.departements.destroy', $departement) }}" method="POST" onsubmit="return confirm('Supprimer ce département ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-3 mb-0">Aucun département enregistré.</p>
            @endif
        </div>
    </div>

    {{-- SOUS-PREFECTURES --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="bi bi-signpost-split"></i> Sous-préfectures</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalSousPrefecture"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div class="card-body p-0">
            @if($sousPrefectures->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Nom</th><th>Département</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @foreach($sousPrefectures as $sp)
                        <tr>
                            <td>{{ $sp->nom }}</td>
                            <td>{{ $sp->departement?->nom ?? '—' }}</td>
                            <td class="text-end">
                                <form action="{{ route('localisation.sous-prefectures.destroy', $sp) }}" method="POST" onsubmit="return confirm('Supprimer cette sous-préfecture ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-3 mb-0">Aucune sous-préfecture enregistrée.</p>
            @endif
        </div>
    </div>

    {{-- COMMUNES --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="bi bi-buildings"></i> Communes</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCommune"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div class="card-body p-0">
            @if($communes->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Nom</th><th>Département</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @foreach($communes as $commune)
                        <tr>
                            <td>{{ $commune->nom }}</td>
                            <td>{{ $commune->departement?->nom ?? '—' }}</td>
                            <td class="text-end">
                                <form action="{{ route('localisation.communes.destroy', $commune) }}" method="POST" onsubmit="return confirm('Supprimer cette commune ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-3 mb-0">Aucune commune enregistrée.</p>
            @endif
        </div>
    </div>

    {{-- LOCALITES --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="bi bi-geo-alt-fill"></i> Localités <span class="text-muted small">(avec coordonnées GPS — affichées sur la carte)</span></span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalLocalite"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div class="card-body p-0">
            @if($localites->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Nom</th><th>Commune</th><th>Latitude</th><th>Longitude</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @foreach($localites as $localite)
                        <tr>
                            <td>{{ $localite->nom }}</td>
                            <td>{{ $localite->commune?->nom ?? '—' }}</td>
                            <td>{{ $localite->latitude }}</td>
                            <td>{{ $localite->longitude }}</td>
                            <td class="text-end">
                                <form action="{{ route('localisation.localites.destroy', $localite) }}" method="POST" onsubmit="return confirm('Supprimer cette localité ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-3 mb-0">Aucune localité enregistrée.</p>
            @endif
        </div>
    </div>

</div>

{{-- MODAL DISTRICT --}}
<div class="modal fade" id="modalDistrict" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('localisation.districts.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouveau district</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REGION --}}
<div class="modal fade" id="modalRegion" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('localisation.regions.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvelle région</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">District</label>
                        <select name="district_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DEPARTEMENT --}}
<div class="modal fade" id="modalDepartement" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('localisation.departements.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouveau département</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Région</label>
                        <select name="region_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->nom }} ({{ $region->district?->nom }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL SOUS-PREFECTURE --}}
<div class="modal fade" id="modalSousPrefecture" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('localisation.sous-prefectures.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvelle sous-préfecture</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Département</label>
                        <select name="departement_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($departements as $departement)
                                <option value="{{ $departement->id }}">{{ $departement->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL COMMUNE --}}
<div class="modal fade" id="modalCommune" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('localisation.communes.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvelle commune</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Département</label>
                        <select name="departement_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($departements as $departement)
                                <option value="{{ $departement->id }}">{{ $departement->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL LOCALITE --}}
<div class="modal fade" id="modalLocalite" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('localisation.localites.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvelle localité</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Commune</label>
                        <select name="commune_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($communes as $commune)
                                <option value="{{ $commune->id }}">{{ $commune->nom }} ({{ $commune->departement?->nom }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="0.0000001" name="latitude" class="form-control" placeholder="Ex : 5.359951" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="0.0000001" name="longitude" class="form-control" placeholder="Ex : -3.981817" required>
                        </div>
                    </div>
                    <p class="small text-muted mb-2">
                        Astuce : cherchez le lieu sur
                        <a href="https://www.google.com/maps" target="_blank" rel="noopener">Google Maps</a>,
                        faites un clic droit dessus, puis copiez les coordonnées affichées.
                    </p>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

@endsection
