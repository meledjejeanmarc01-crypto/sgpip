@extends('layouts.app')
@section('page-title', 'Détail de la réforme')

@section('content')
@push('styles')
<style>
    .rf-hero { background: #fff; border: 1px solid var(--sgspip-border, #ECEFF2); border-radius: 1rem; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.05); margin-bottom: 1.25rem; }
    .rf-flag { display: flex; height: 6px; }
    .rf-flag span { flex: 1; }
    .rf-flag span:nth-child(1) { background: #F4992A; }
    .rf-flag span:nth-child(2) { background: #fff; box-shadow: inset 0 1px 0 #E5E7EB, inset 0 -1px 0 #E5E7EB; }
    .rf-flag span:nth-child(3) { background: #009A44; }
    .rf-hero-body { padding: 1.5rem 1.75rem 1.4rem; }
    .rf-kicker { font-size: .72rem; letter-spacing: .14em; text-transform: uppercase; color: var(--sgspip-orange, #FF8200); font-weight: 700; }
    .rf-title { font-family: Georgia, 'Times New Roman', serif; font-weight: 700; color: var(--sgspip-ink, #1F2937); font-size: 1.65rem; line-height: 1.25; margin: .3rem 0 .75rem; }
    .rf-statut { display: inline-flex; align-items: center; gap: .4rem; border-radius: 2rem; padding: .3rem .9rem; font-size: .82rem; font-weight: 600; border: 1px solid transparent; }
    .rf-statut-demarree { background: #E0F2FE; color: #0369A1; border-color: #BAE6FD; }
    .rf-statut-encours { background: #FFF1E0; color: #C2410C; border-color: #FFD9B0; }
    .rf-statut-achevee { background: #E6F6ED; color: #047857; border-color: #BFE8D2; }
    .rf-chips { display: flex; flex-wrap: wrap; gap: .65rem; margin-top: 1.1rem; }
    .rf-chip { display: flex; align-items: center; gap: .6rem; background: #F8FAFC; border: 1px solid var(--sgspip-border, #ECEFF2); border-radius: .75rem; padding: .55rem .85rem; }
    .rf-chip > i { color: var(--sgspip-orange, #FF8200); font-size: 1.15rem; }
    .rf-chip .lbl { display: block; font-size: .66rem; text-transform: uppercase; letter-spacing: .06em; color: var(--sgspip-muted, #6B7280); font-weight: 600; }
    .rf-chip .val { display: block; font-size: .88rem; font-weight: 600; color: var(--sgspip-ink, #1F2937); }
    .rf-chip .sub { display: block; font-size: .74rem; color: var(--sgspip-muted, #6B7280); }

    .rf-kpi { background: #fff; border: 1px solid var(--sgspip-border, #ECEFF2); border-top: 4px solid var(--c, #FF8200); border-radius: 1rem; padding: 1.05rem 1.25rem; height: 100%; box-shadow: 0 1px 4px rgba(0,0,0,.04); }
    .rf-kpi .lbl { font-size: .7rem; text-transform: uppercase; letter-spacing: .07em; color: var(--sgspip-muted, #6B7280); font-weight: 700; }
    .rf-kpi .val { font-size: 1.45rem; font-weight: 800; color: var(--sgspip-ink, #1F2937); line-height: 1.2; margin-top: .25rem; }
    .rf-kpi .val small { font-size: .74rem; font-weight: 600; color: var(--sgspip-muted, #6B7280); }
    .rf-kpi .val.texte { font-size: 1.05rem; font-weight: 700; }

    .rf-bloc { background: #fff; border: 1px solid var(--sgspip-border, #ECEFF2); border-radius: 1rem; padding: 1.25rem 1.4rem; box-shadow: 0 1px 4px rgba(0,0,0,.04); height: 100%; }
    .rf-bloc h6 { display: flex; align-items: center; gap: .5rem; color: var(--sgspip-orange-dark, #E06E00); font-weight: 700; border-bottom: 2px solid #FFE3C7; padding-bottom: .5rem; margin-bottom: 1rem; }
    .rf-texte { white-space: pre-line; color: #374151; line-height: 1.65; margin: 0; }
    .rf-vide { color: #9CA3AF; }

    .rf-split { display: flex; height: 14px; border-radius: 7px; overflow: hidden; background: #E5E7EB; }
    .rf-split > span { display: block; height: 100%; }
    .rf-legende { display: flex; flex-wrap: wrap; gap: .4rem 1.4rem; margin-top: .7rem; font-size: .82rem; color: #374151; }
    .rf-legende i { display: inline-block; width: .7rem; height: .7rem; border-radius: 50%; margin-right: .4rem; }

    .rf-taux + .rf-taux { margin-top: 1.1rem; }
    .rf-taux .tete { display: flex; justify-content: space-between; align-items: baseline; font-size: .84rem; color: #374151; margin-bottom: .35rem; }
    .rf-taux .tete strong { font-size: 1.05rem; color: var(--sgspip-ink, #1F2937); }
    .rf-barre { height: 10px; border-radius: 5px; background: #E5E7EB; overflow: hidden; }
    .rf-barre > span { display: block; height: 100%; border-radius: 5px; }

    .rf-frise { display: flex; align-items: center; gap: .75rem; }
    .rf-frise .point { text-align: center; min-width: 5.5rem; }
    .rf-frise .point .lbl { font-size: .68rem; text-transform: uppercase; letter-spacing: .07em; color: var(--sgspip-muted, #6B7280); font-weight: 700; }
    .rf-frise .point .val { font-size: 1.5rem; font-weight: 800; color: var(--sgspip-ink, #1F2937); }
    .rf-frise .trait { flex: 1; height: 4px; border-radius: 2px; background: linear-gradient(90deg, #F4992A, #009A44); position: relative; }
    .rf-meta { margin-top: 1.1rem; display: grid; gap: .5rem; font-size: .88rem; color: #374151; }
    .rf-meta i { color: var(--sgspip-orange, #FF8200); margin-right: .5rem; }

    .rf-trim { text-align: center; padding: 1rem .75rem; background: #FFF8EF; border: 1px solid #FFE3C7; border-radius: .85rem; height: 100%; }
    .rf-trim .num { width: 2.3rem; height: 2.3rem; border-radius: 50%; background: var(--sgspip-orange, #FF8200); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; margin-bottom: .45rem; }
    .rf-trim .lbl { font-size: .72rem; text-transform: uppercase; letter-spacing: .06em; color: var(--sgspip-muted, #6B7280); font-weight: 600; }
    .rf-trim .val { font-weight: 600; color: var(--sgspip-ink, #1F2937); margin-top: .2rem; word-break: break-word; }

    @media print {
        .rf-hero, .rf-kpi, .rf-bloc, .rf-trim { break-inside: avoid; box-shadow: none !important; }
        .rf-title { font-size: 1.35rem; }
    }
</style>
@endpush
@php
    $statuts = [
        'demarree' => ['Démarrée', 'rf-statut-demarree', 'bi-play-circle'],
        'en_cours' => ['En cours', 'rf-statut-encours', 'bi-arrow-repeat'],
        'achevee'  => ['Achevée', 'rf-statut-achevee', 'bi-check-circle'],
    ];
    $st = $statuts[$reforme->statut] ?? [ucfirst(str_replace('_', ' ', (string) $reforme->statut)), 'rf-statut-demarree', 'bi-circle'];

    $fcfa = fn ($n) => number_format((float) $n, 0, ',', ' ');
    $budget = (float) $reforme->budget_global;
    $etat = (float) $reforme->montant_etat;
    $autres = (float) $reforme->montant_autres_bailleurs;
    $totalFinance = $etat + $autres;
    $pEtat = $budget > 0 ? min(100, round($etat / $budget * 100, 1)) : 0;
    $pAutres = $budget > 0 ? min(100 - $pEtat, round($autres / $budget * 100, 1)) : 0;
    $pReste = max(0, round(100 - $pEtat - $pAutres, 1));
    $reste = max(0, $budget - $totalFinance);

    $periode = collect([$reforme->annee_debut, $reforme->annee_fin])->filter()->join(' – ');
    $duree = ($reforme->annee_debut && $reforme->annee_fin && $reforme->annee_fin >= $reforme->annee_debut)
        ? ($reforme->annee_fin - $reforme->annee_debut + 1) : null;

    $taux = [
        ['Année précédente', $reforme->taux_execution_annee_precedente, '#009A44'],
        ['Prévisionnel année en cours', $reforme->taux_execution_previsionnel, '#FF8200'],
    ];
    $trimestres = [1 => $reforme->cible_trimestre_1, 2 => $reforme->cible_trimestre_2, 3 => $reforme->cible_trimestre_3, 4 => $reforme->cible_trimestre_4];

    $textes = [
        ['Description', 'bi-card-text', $reforme->description],
        ['Résultat global attendu', 'bi-bullseye', $reforme->resultat_global_attendu],
        ['Livrables attendus', 'bi-box-seam', $reforme->livrables_attendus],
        ['Indicateurs', 'bi-graph-up-arrow', $reforme->indicateurs],
        ['Observations', 'bi-chat-left-text', $reforme->observations],
    ];
    $textes = array_values(array_filter($textes, fn ($t) => filled($t[2])));
@endphp

{{-- Barre d'actions (jamais imprimée) --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 no-print">
    <a href="{{ route('reformes.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Retour aux réformes</a>
    <div class="d-flex flex-wrap gap-2">
        <button type="button" onclick="window.print()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer"></i> Imprimer la fiche</button>
        @if(auth()->user()->peutModifier('reformes'))
            <a href="{{ route('reformes.edit', $reforme) }}" class="btn btn-sm btn-brand"><i class="bi bi-pencil"></i> Modifier</a>
            <form action="{{ route('reformes.destroy', $reforme) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette réforme ?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Supprimer</button>
            </form>
        @endif
    </div>
</div>

{{-- En-tête de la fiche --}}
<div class="rf-hero">
    <div class="rf-flag"><span></span><span></span><span></span></div>
    <div class="rf-hero-body">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
            <div class="rf-kicker">Réforme</div>
            <span class="rf-statut {{ $st[1] }}"><i class="bi {{ $st[2] }}"></i> {{ $st[0] }}</span>
        </div>
        <h1 class="rf-title">{{ $reforme->libelle }}</h1>

        <div class="rf-chips">
            <div class="rf-chip"><i class="bi bi-building"></i><div>
                <span class="lbl">Structure pilote</span>
                <span class="val">{{ $reforme->structure->libelle ?? '—' }}</span>
            </div></div>
            <div class="rf-chip"><i class="bi bi-diagram-3"></i><div>
                <span class="lbl">Axe</span>
                <span class="val">{{ $reforme->axe->libelle ?? '—' }}</span>
                @if($reforme->axe?->programme)<span class="sub">{{ $reforme->axe->programme->nom }}</span>@endif
            </div></div>
            <div class="rf-chip"><i class="bi bi-calendar-range"></i><div>
                <span class="lbl">Période</span>
                <span class="val">{{ $periode ?: '—' }}</span>
            </div></div>
            @if($reforme->localite)
            <div class="rf-chip"><i class="bi bi-geo-alt"></i><div>
                <span class="lbl">Localité</span>
                <span class="val">{{ $reforme->localite }}</span>
            </div></div>
            @endif
            <div class="rf-chip"><i class="bi bi-send"></i><div>
                <span class="lbl">Transmission au SGG</span>
                <span class="val">{{ optional($reforme->date_transmission_sgg)->format('d/m/Y') ?? '—' }}</span>
            </div></div>
        </div>
    </div>
</div>

{{-- Chiffres clés --}}
<div class="row g-3 mb-3">
    <div class="col-md-6 col-xl-3">
        <div class="rf-kpi" style="--c:#FF8200;">
            <div class="lbl">Budget global</div>
            <div class="val">{{ $fcfa($budget) }} <small>FCFA</small></div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="rf-kpi" style="--c:#009A44;">
            <div class="lbl">Montant État</div>
            <div class="val">{{ $fcfa($etat) }} <small>FCFA</small></div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="rf-kpi" style="--c:#F4992A;">
            <div class="lbl">Autres bailleurs</div>
            <div class="val">{{ $fcfa($autres) }} <small>FCFA</small></div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="rf-kpi" style="--c:#6B7280;">
            <div class="lbl">Source de financement</div>
            <div class="val texte">{{ $reforme->source_financement ?: '—' }}</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    {{-- Financement --}}
    <div class="col-lg-7">
        <div class="rf-bloc">
            <h6><i class="bi bi-cash-coin"></i> Répartition du financement</h6>
            @if($budget > 0)
                <div class="rf-split" title="Répartition du budget global">
                    <span style="width: {{ $pEtat }}%; background:#009A44;"></span>
                    <span style="width: {{ $pAutres }}%; background:#F4992A;"></span>
                </div>
                <div class="rf-legende">
                    <span><i style="background:#009A44;"></i>État : <strong>{{ $pEtat }} %</strong></span>
                    <span><i style="background:#F4992A;"></i>Autres bailleurs : <strong>{{ $pAutres }} %</strong></span>
                    <span><i style="background:#D1D5DB;"></i>Non couvert : <strong>{{ $pReste }} %</strong> ({{ $fcfa($reste) }} FCFA)</span>
                </div>
                @if($totalFinance > $budget)
                    <div class="small text-danger mt-2"><i class="bi bi-exclamation-triangle"></i> Les montants État et autres bailleurs dépassent le budget global.</div>
                @endif
            @else
                <p class="rf-texte rf-vide">Budget global non renseigné.</p>
            @endif
            <div class="row mt-3 small">
                <div class="col-sm-6"><span class="text-muted">Code PJGouv :</span> <strong>{{ $reforme->code_pjgouv ?: '—' }}</strong></div>
                <div class="col-sm-6"><span class="text-muted">Code PSGouv :</span> <strong>{{ $reforme->code_psgouv ?: '—' }}</strong></div>
            </div>
        </div>
    </div>

    {{-- Avancement --}}
    <div class="col-lg-5">
        <div class="rf-bloc">
            <h6><i class="bi bi-speedometer2"></i> Taux d'exécution</h6>
            @foreach($taux as [$libelle, $valeur, $couleur])
                @php $largeur = is_null($valeur) ? 0 : max(0, min(100, (float) $valeur)); @endphp
                <div class="rf-taux">
                    <div class="tete"><span>{{ $libelle }}</span><strong>{{ is_null($valeur) ? '—' : rtrim(rtrim(number_format((float) $valeur, 2, ',', ' '), '0'), ',').' %' }}</strong></div>
                    <div class="rf-barre"><span style="width: {{ $largeur }}%; background: {{ $couleur }};"></span></div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Calendrier --}}
<div class="rf-bloc mb-3">
    <h6><i class="bi bi-calendar-check"></i> Calendrier</h6>
    <div class="row align-items-center g-3">
        <div class="col-lg-7">
            <div class="rf-frise">
                <div class="point"><div class="lbl">Début</div><div class="val">{{ $reforme->annee_debut ?: '—' }}</div></div>
                <div class="trait"></div>
                <div class="point"><div class="lbl">Fin</div><div class="val">{{ $reforme->annee_fin ?: '—' }}</div></div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="rf-meta mt-0">
                <div><i class="bi bi-hourglass-split"></i>Durée : <strong>{{ $duree ? $duree.' an'.($duree > 1 ? 's' : '') : '—' }}</strong></div>
                <div><i class="bi bi-send"></i>Transmission au SGG : <strong>{{ optional($reforme->date_transmission_sgg)->format('d/m/Y') ?? '—' }}</strong></div>
            </div>
        </div>
    </div>
</div>

{{-- Cibles trimestrielles --}}
<div class="rf-bloc mb-3">
    <h6><i class="bi bi-bullseye"></i> Cibles trimestrielles</h6>
    <div class="row g-3">
        @foreach($trimestres as $n => $cible)
            <div class="col-6 col-lg-3">
                <div class="rf-trim">
                    <div class="num">T{{ $n }}</div>
                    <div class="lbl">Trimestre {{ $n }}</div>
                    <div class="val">{!! filled($cible) ? e($cible) : '<span class="rf-vide">—</span>' !!}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Textes : seuls les champs renseignés sont affichés --}}
@if(count($textes))
<div class="row g-3 mb-3">
    @foreach($textes as [$titre, $icone, $contenu])
        <div class="{{ in_array($titre, ['Description', 'Observations']) ? 'col-12' : 'col-lg-6' }}">
            <div class="rf-bloc">
                <h6><i class="bi {{ $icone }}"></i> {{ $titre }}</h6>
                <p class="rf-texte">{{ $contenu }}</p>
            </div>
        </div>
    @endforeach
</div>
@endif
@endsection
