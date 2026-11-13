{{-- Boutons d'onglets des volets de la fiche projet. Usage : @include('projets.partials.volets_nav', ['only' => ['budgets','marches']]) --}}
@php
    $court = [
        'beneficiaires' => 'Bénéficiaires',
        'emplois' => "Opportunités d'emploi",
        'comites' => 'Cadre de gestion',
        'charges' => 'Charges récurrentes',
        'budgets' => 'Programmation budgétaire',
        'marches' => 'Marchés',
        'echeanciers' => 'Échéancier AE-CP',
        'criteres' => "Critères d'appréciation",
        'ventilations' => 'Ventilation interne',
        'plan_decaissement' => 'Plan de décaissement',
        'plan_global' => 'Mise en œuvre (global)',
        'plan_detaille' => 'Mise en œuvre (détaillé)',
        'plan_travail' => 'Plan de travail annuel',
        'demande_financement' => 'Demande de financement',
        'previsions_valeur' => 'Prévisions en valeur',
        'programmation_lf' => 'Programmation LF',
    ];
@endphp
@foreach(($only ?? array_keys($court)) as $cle)
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#volet-{{ $cle }}">{{ $court[$cle] }}</button></li>
@endforeach
