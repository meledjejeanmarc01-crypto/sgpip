@extends('layouts.app')
@section('page-title', 'Tableau de bord')
@section('content')

<div class="row g-3 mb-3">
    <div class="col-6 col-lg-3">
        <div class="card card-stat p-3 h-100">
            <div class="text-muted small">Projets</div>
            <div class="fs-4 fw-semibold">{{ $stats['total_projets'] }}</div>
            <div class="small text-muted">{{ $stats['projets_en_cours'] }} en cours</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-stat p-3 h-100">
            <div class="text-muted small">Avancement moyen</div>
            <div class="fs-4 fw-semibold">{{ $stats['avancement_moyen'] }}%</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-stat p-3 h-100">
            <div class="text-muted small">En retard</div>
            <div class="fs-4 fw-semibold {{ $stats['projets_retardes'] ? 'text-danger' : '' }}">{{ $stats['projets_retardes'] }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-stat p-3 h-100">
            <div class="text-muted small">Décaissé</div>
            <div class="fs-6 fw-semibold">{{ number_format($stats['montant_decaisse'], 0, ',', ' ') }} <span class="small text-muted">FCFA</span></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card card-stat p-3">
            <h6 class="fw-semibold mb-3 text-muted small text-uppercase"><i class="bi bi-geo-alt me-1"></i>Carte des projets</h6>
            <div id="map" style="height: 340px; border-radius:.5rem;"></div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-semibold text-muted small text-uppercase m-0">Projets récents</h6>
                <a href="{{ route('projets.index') }}" class="small text-decoration-none">Voir tout</a>
            </div>
            @foreach($projetsRecents->take(5) as $p)
                <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
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

<div class="card card-stat p-3 mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-semibold text-muted small text-uppercase m-0">Top secteurs</h6>
        <a href="{{ route('projets.index') }}" class="small text-decoration-none">Voir tout</a>
    </div>
    <div class="row">
        @foreach($projetsParSecteur->take(6) as $s)
            <div class="col-md-4 d-flex justify-content-between small py-1">
                <span class="text-muted text-truncate me-2">{{ $s->libelle }}</span><span class="fw-semibold">{{ $s->projets_count }}</span>
            </div>
        @endforeach
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

    const zones = @json($zonesCarteData);

    zones.forEach(z => {
        if (!z.lat || !z.lng) return;
        const radius = 8 + Math.min(z.nb, 10) * 3;
        L.circleMarker([z.lat, z.lng], {
            radius: radius,
            color: '#FF8200',
            fillColor: '#FF8200',
            fillOpacity: 0.5
        }).addTo(map).bindPopup(`<strong>${z.libelle}</strong><br>${z.type}<br>${z.nb} projet(s)`);
    });
</script>
@endpush
