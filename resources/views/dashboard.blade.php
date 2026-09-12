@extends('layouts.app')
@section('page-title', 'Tableau de bord')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-stat p-3">
            <div class="text-muted small">Projets (total)</div>
            <div class="fs-3 fw-bold">{{ $stats['total_projets'] }}</div>
            <div class="small text-muted">{{ $stats['projets_en_cours'] }} en cours · {{ $stats['projets_termines'] }} terminés</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat p-3">
            <div class="text-muted small">Avancement physique moyen</div>
            <div class="fs-3 fw-bold">{{ $stats['avancement_moyen'] }}%</div>
            <div class="progress mt-2" style="height:6px;"><div class="progress-bar bg-success" style="width: {{ $stats['avancement_moyen'] }}%"></div></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat p-3">
            <div class="text-muted small">Projets en retard</div>
            <div class="fs-3 fw-bold text-danger">{{ $stats['projets_retardes'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat p-3">
            <div class="text-muted small">Bailleurs / Structures</div>
            <div class="fs-3 fw-bold">{{ $stats['total_bailleurs'] }} / {{ $stats['total_structures'] }}</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-stat p-3">
            <div class="text-muted small">Montant engagé (financements)</div>
            <div class="fs-4 fw-bold">{{ number_format($stats['montant_engage'], 0, ',', ' ') }} FCFA</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat p-3">
            <div class="text-muted small">Montant décaissé</div>
            <div class="fs-4 fw-bold">{{ number_format($stats['montant_decaisse'], 0, ',', ' ') }} FCFA</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat p-3">
            <div class="text-muted small">Montant dépensé</div>
            <div class="fs-4 fw-bold">{{ number_format($stats['montant_depense'], 0, ',', ' ') }} FCFA</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card card-stat p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-1"></i>Carte des projets par zone de localisation</h6>
            <div id="map" style="height: 420px; border-radius:.5rem;"></div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-stat p-3 mb-3">
            <h6 class="fw-bold mb-3">Répartition des projets par secteur</h6>
            @foreach($projetsParSecteur as $s)
                <div class="d-flex justify-content-between small mb-1">
                    <span>{{ $s->libelle }}</span><span class="fw-semibold">{{ $s->projets_count }}</span>
                </div>
                <div class="progress mb-2" style="height:6px;">
                    <div class="progress-bar" style="background-color:#FF8200; width: {{ $stats['total_projets'] ? round($s->projets_count / $stats['total_projets'] * 100) : 0 }}%"></div>
                </div>
            @endforeach
        </div>
        <div class="card card-stat p-3">
            <h6 class="fw-bold mb-3">Projets récents</h6>
            @foreach($projetsRecents as $p)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <a href="{{ route('projets.show', $p) }}" class="fw-semibold text-decoration-none">{{ $p->intitule }}</a>
                        <div class="small text-muted">{{ $p->structure->libelle ?? '' }} · {{ $p->secteur->libelle ?? '' }}</div>
                    </div>
                    <span class="badge badge-statut-{{ $p->statut }}">{{ str_replace('_',' ',$p->statut) }}</span>
                </div>
            @endforeach
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
