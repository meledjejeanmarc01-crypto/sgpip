@extends('layouts.app')
@section('page-title', 'Détail du rapport')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3 no-print">
    <a href="{{ route('rapports.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Retour aux rapports</a>
    <button onclick="window.print()" class="btn btn-sm text-white" style="background:#FF8200;">
        <i class="bi bi-printer"></i> Imprimer le rapport
    </button>
</div>

<div class="card card-stat p-4" style="max-width:800px;">
    {{-- En-tête officiel, visible uniquement à l'impression --}}
    <div class="d-none d-print-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
        <div>
            <div class="fw-bold">République de Côte d'Ivoire</div>
            <div class="small text-muted">Ministère de l'Économie, du Plan et du Développement</div>
            <div class="small text-muted">SGSPIP — Système Intégré de Gestion et de Suivi des Projets d'Investissement Public</div>
        </div>
        <div class="text-end small text-muted">
            Imprimé le {{ now()->format('d/m/Y à H:i') }}
        </div>
    </div>

    <span class="badge bg-light text-dark border mb-2">{{ str_replace('_',' ',$rapport->type) }}</span>
    <h5 class="fw-bold">{{ $rapport->titre }}</h5>
    <p class="text-muted mb-1">Projet : <a href="{{ route('projets.show', $rapport->projet) }}">{{ $rapport->projet->intitule ?? '—' }}</a></p>
    <p class="text-muted mb-3">Rédigé par {{ $rapport->utilisateur->prenom ?? '' }} {{ $rapport->utilisateur->nom ?? '' }} le {{ $rapport->date->format('d/m/Y') }}</p>

    <hr class="d-none d-print-block">

    <p style="white-space: pre-line;">{{ $rapport->donnees }}</p>

    @if($rapport->fichier)
        <a href="{{ route('rapports.download', $rapport) }}" class="btn btn-sm btn-outline-secondary no-print"><i class="bi bi-download"></i> Télécharger le fichier joint</a>
    @endif

    {{-- Zone de signature, visible uniquement à l'impression --}}
    <div class="d-none d-print-block mt-5 pt-4">
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
