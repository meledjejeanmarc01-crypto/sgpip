@extends('layouts.app')

@section('title', 'Carte du territoire - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-1"><i class="bi bi-geo-alt"></i> Carte du territoire</h2>
        <p class="text-muted mb-0">Localisation des projets d'investissement public en Côte d'Ivoire</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div id="carte" style="height: 600px; border-radius: 10px; overflow: hidden;"></div>
        </div>
    </div>

    @if($projets->isEmpty())
        <div class="alert alert-warning mt-3">
            <i class="bi bi-exclamation-triangle"></i>
            Aucun projet géolocalisé pour le moment. Pour qu'un projet apparaisse sur la carte, il faut :
            <ol class="mb-0 mt-2">
                <li>Créer une <strong>localité</strong> avec ses coordonnées GPS dans
                    <a href="{{ route('localisation.index') }}">Localisation géographique</a> ;</li>
                <li>Puis, sur la fiche du projet (modifier), sélectionner cette localité dans le formulaire de localisation.</li>
            </ol>
        </div>
    @endif

</div>

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('carte').setView([7.539989, -5.54708], 7); // Centre approximatif de la Côte d'Ivoire

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(map);

        const projets = @json($projetsCarte);

        const bounds = [];

        projets.forEach(function (p) {
            const marker = L.marker([p.lat, p.lng]).addTo(map);

            marker.bindPopup(
                '<strong>' + p.reference + '</strong><br>' +
                p.intitule + '<br>' +
                '<span class="text-muted">' + (p.structure ?? '') + '</span><br>' +
                '<a href="' + p.url + '">Voir le projet</a>'
            );

            bounds.push([p.lat, p.lng]);
        });

        if (bounds.length === 1) {
            map.setView(bounds[0], 13);
        } else if (bounds.length > 1) {
            map.fitBounds(bounds, { padding: [30, 30] });
        }

        // Sécurité : si la carte est initialisée avant que son conteneur
        // n'ait sa taille finale (ex. chargement de la mise en page),
        // on force un recalcul de la taille une fois la page prête.
        window.addEventListener('load', function () {
            map.invalidateSize();
        });
    </script>
@endpush

@endsection
