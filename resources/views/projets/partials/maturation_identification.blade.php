{{-- Fiche de maturation, étape 1 : identification, maîtrise, personnes ressources, périmètre, attributions --}}
@php
    $dash = fn ($v) => filled($v) ? $v : '—';
    $personnes = ['responsable' => 'Responsable du projet', 'redacteur' => 'Rédacteur de la fiche'];
@endphp
<div class="card card-stat p-4 mb-3">
    <h6 class="fw-bold mb-3">Identification et maîtrise d'ouvrage</h6>
    <div class="row g-3">
        <div class="col-md-4"><div class="small text-muted">Date d'identification de l'idée projet</div><div>{{ optional($projet->date_identification)->format('d/m/Y') ?: '—' }}</div></div>
        <div class="col-md-4"><div class="small text-muted">Section budgétaire</div><div>{{ $dash($projet->section_budgetaire) }}</div></div>
        <div class="col-md-4"><div class="small text-muted">Structure responsable</div><div>{{ $dash(optional($projet->structure)->libelle) }}</div></div>
        <div class="col-md-4"><div class="small text-muted">Maître d'ouvrage</div><div>{{ $dash($projet->maitre_ouvrage) }}</div></div>
        <div class="col-md-4"><div class="small text-muted">Maître d'ouvrage délégué</div><div>{{ $dash($projet->maitre_ouvrage_delegue) }}</div></div>
        <div class="col-md-4"><div class="small text-muted">Maître d'ouvrage associé</div><div>{{ $dash($projet->maitre_ouvrage_associe) }}</div></div>
        <div class="col-md-4"><div class="small text-muted">Maître d'œuvre</div><div>{{ $dash($projet->maitre_oeuvre) }}</div></div>
        <div class="col-md-4"><div class="small text-muted">Maître d'œuvre délégué</div><div>{{ $dash($projet->maitre_oeuvre_delegue) }}</div></div>
        <div class="col-md-4"><div class="small text-muted">Maître d'œuvre associé</div><div>{{ $dash($projet->maitre_oeuvre_associe) }}</div></div>
    </div>

    <h6 class="fw-bold mt-4 mb-3">Personnes ressources</h6>
    <div class="row g-3">
        @foreach($personnes as $pref => $titre)
            <div class="col-md-6">
                <div class="border rounded p-3 h-100">
                    <div class="fw-semibold mb-2">{{ $titre }}</div>
                    <div><span class="text-muted small">Nom et prénoms :</span> {{ $dash($projet->{$pref.'_nom'}) }}</div>
                    <div><span class="text-muted small">Fonction :</span> {{ $dash($projet->{$pref.'_fonction'}) }}</div>
                    <div><span class="text-muted small">Téléphone :</span> {{ $dash($projet->{$pref.'_telephone'}) }}</div>
                    <div><span class="text-muted small">Cellulaire :</span> {{ $dash($projet->{$pref.'_cellulaire'}) }}</div>
                    <div><span class="text-muted small">E-mail :</span> {{ $dash($projet->{$pref.'_email'}) }}</div>
                    <div><span class="text-muted small">Adresse géographique :</span> {{ $dash($projet->{$pref.'_adresse'}) }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <h6 class="fw-bold mt-4 mb-2">Périmètre : sections de compétence</h6>
    @forelse(($projet->perimetre_sections ?? []) as $i => $section)
        <div><span class="text-muted small">Section {{ $i + 1 }} :</span> {{ $section }}</div>
    @empty
        <div class="text-muted">—</div>
    @endforelse

    <h6 class="fw-bold mt-4 mb-2">Attributions du Ministère en lien avec le projet</h6>
    <div style="white-space: pre-line;">{{ $dash($projet->attributions_ministere) }}</div>
</div>
