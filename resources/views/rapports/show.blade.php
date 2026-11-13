@extends(request()->boolean('imprimer') ? 'rapports.layout_apercu' : 'layouts.app')
@section('page-title', 'Détail du rapport')
@section('content')
@php
    // Aperçu avant impression : la liste des rapports et le bouton « Imprimer le rapport » ouvrent cette page avec ?imprimer=1.
    $apercu = request()->boolean('imprimer');
    $axe = $rapport->projet?->axe;
    $programme = $axe?->programme;
@endphp

@unless($apercu)
<div class="d-flex justify-content-between align-items-center mb-3 no-print">
    <a href="{{ route('rapports.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Retour aux rapports</a>
    <a href="{{ route('rapports.show', [$rapport, 'imprimer' => 1]) }}" target="_blank" class="btn btn-sm btn-brand">
        <i class="bi bi-printer"></i> Imprimer le rapport
    </a>
</div>
@endunless

{{-- L'en-tête officiel (armoiries, République, ministère) et le pied de page sont ajoutés
     par le gabarit (layouts/app ou rapports/layout_apercu + partials/entete_document + partials/impression). --}}
<div @if(! $apercu) class="card card-stat p-4" style="max-width:800px;" @endif>
    <span class="badge bg-light text-dark border mb-2">{{ str_replace('_',' ',$rapport->type) }}</span>
    <h5 class="fw-bold">{{ $rapport->titre }}</h5>

    <table class="table table-bordered align-middle my-3">
        <tbody>
            <tr>
                <th style="width:28%;">Projet</th>
                <td>
                    @if($apercu)
                        {{ $rapport->projet->intitule ?? '—' }}
                    @else
                        <a href="{{ route('projets.show', $rapport->projet) }}">{{ $rapport->projet->intitule ?? '—' }}</a>
                    @endif
                </td>
            </tr>
            <tr><th>Programme</th><td>{{ $programme->nom ?? '—' }}</td></tr>
            <tr><th>Axe</th><td>{{ $axe->libelle ?? '—' }}</td></tr>
            @if($rapport->periode)
                <tr><th>Période</th><td>{{ $rapport->periode }}</td></tr>
            @endif
            <tr><th>Date du rapport</th><td>{{ $rapport->date->format('d/m/Y') }}</td></tr>
            <tr><th>Rédigé par</th><td>{{ $rapport->utilisateur->prenom ?? '' }} {{ $rapport->utilisateur->nom ?? '' }}</td></tr>
        </tbody>
    </table>

    <h6 class="fw-bold text-uppercase text-muted mt-4 mb-2" style="font-size:.8rem; letter-spacing:.05em;">Contenu du rapport</h6>
    <p style="white-space: pre-line;">{{ $rapport->donnees }}</p>

    @if($rapport->fichier)
        <a href="{{ route('rapports.download', $rapport) }}" class="btn btn-sm btn-outline-secondary no-print"><i class="bi bi-download"></i> Télécharger le fichier joint</a>
    @endif

    {{-- Zone de signature : visible dans l'aperçu, et à l'impression sur la page normale --}}
    <div class="{{ $apercu ? '' : 'd-none d-print-block' }} mt-5 pt-4">
        <div class="row">
            <div class="col-6">
                <div class="small text-muted">Rédigé par</div>
                <div class="mt-5">{{ $rapport->utilisateur->prenom ?? '' }} {{ $rapport->utilisateur->nom ?? '' }}</div>
            </div>
            <div class="col-6 text-end">
                <div class="small text-muted">Visa / Cachet</div>
            </div>
        </div>
    </div>
</div>
@endsection
