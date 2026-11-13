{{--
  Volets de la fiche projet (canevas du Ministère) : bénéficiaires, emplois, comités, charges récurrentes,
  budgets, marchés, échéancier AE-CP, critères d'appréciation.
  Utilisation : @include('projets.partials.volets', ['only' => ['budgets', 'marches']])   (sans "only" : tous les volets)
--}}
@php
    $defs = \App\Support\FicheVolets::definitions();
    $cles = $only ?? array_keys($defs);
    $marchesProjet = $projet->marches()->orderBy('id')->get();
    $lectureSeule = ! auth()->user()?->peutModifierProjet($projet);
    $uid = 'volets-'.substr(md5(implode(',', $cles)), 0, 6);
    $formater = function ($c, $ligne) {
        $v = $ligne->{$c['name']} ?? null;
        if ($v === null || $v === '') { return '—'; }
        if ($c['type'] === 'select') { return $c['options'][$v] ?? $v; }
        if ($c['type'] === 'marche') { return optional($ligne->marche)->objet ?? '—'; }
        if ($c['type'] === 'year') { return $v; }
        if ($c['type'] === 'number') {
            return str_starts_with($c['name'], 'taux_') ? number_format((float) $v, 0, ',', ' ').' %' : number_format((float) $v, 0, ',', ' ');
        }
        return \Illuminate\Support\Str::limit($v, 60);
    };
@endphp
<style>
    #{{ $uid }} .accordion-item { border: 1px solid #eef0f3; border-radius: .9rem !important; margin-bottom: .6rem; overflow: hidden; }
    #{{ $uid }} .accordion-button { font-weight: 600; }
    #{{ $uid }} .accordion-button:not(.collapsed) { background: #FEF5E7; color: #D9811A; box-shadow: none; }
    #{{ $uid }} .accordion-button:focus { box-shadow: 0 0 0 .2rem rgba(244,153,42,.2); }
    #{{ $uid }} .accordion-button .badge { background: #F4992A !important; }
</style>
<div class="accordion mb-3" id="{{ $uid }}">
@foreach($cles as $cle)
    @php
        $def = $defs[$cle];
        $lignes = $def['scope'] === 'projet'
            ? $def['model']::where('projet_id', $projet->id)->orderBy('id')->get()
            : $def['model']::whereIn('marche_id', $marchesProjet->pluck('id'))->with('marche')->orderBy('id')->get();
        $champsAffiches = collect($def['champs'])->whereIn('name', $def['colonnes'])->sortBy(fn ($c) => array_search($c['name'], $def['colonnes']))->values();
        $besoinMarche = collect($def['champs'])->contains('type', 'marche') && $marchesProjet->isEmpty();
    @endphp
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $uid }}-{{ $cle }}">
                {{ $def['titre'] }} <span class="badge bg-secondary ms-2">{{ $lignes->count() }}</span>
            </button>
        </h2>
        <div id="{{ $uid }}-{{ $cle }}" class="accordion-collapse collapse" data-bs-parent="#{{ $uid }}">
            <div class="accordion-body">
                <p class="text-muted small">{{ $def['aide'] }}</p>

                @if($lignes->isEmpty())
                    <p class="text-muted fst-italic">Aucune ligne enregistrée.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead><tr>
                                @foreach($champsAffiches as $c)<th>{{ $c['label'] }}</th>@endforeach
                                @unless($lectureSeule)<th style="width:110px"></th>@endunless
                            </tr></thead>
                            <tbody>
                            @foreach($lignes as $ligne)
                                <tr>
                                    @foreach($champsAffiches as $c)<td>{{ $formater($c, $ligne) }}</td>@endforeach
                                    @unless($lectureSeule)
                                    <td class="text-end text-nowrap">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#{{ $uid }}-{{ $cle }}-edit-{{ $ligne->id }}" title="Modifier"><i class="bi bi-pencil"></i></button>
                                        <form method="POST" action="{{ route('fiche.destroy', [$cle, $ligne->id]) }}" class="d-inline" onsubmit="return confirm('Supprimer cette ligne ?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                    @endunless
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @unless($lectureSeule)
                    @if($besoinMarche)
                        <div class="alert alert-info py-2 mb-0">Enregistrez d'abord un marché (volet « Marchés ») pour pouvoir saisir son échéancier.</div>
                    @else
                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $uid }}-{{ $cle }}-ajout"><i class="bi bi-plus-lg me-1"></i>Ajouter : {{ $def['singulier'] }}</button>
                        <div class="collapse mt-3" id="{{ $uid }}-{{ $cle }}-ajout">
                            <form method="POST" action="{{ route('fiche.store', [$projet, $cle]) }}" class="border rounded p-3">
                                @csrf
                                <div class="row g-2">
                                    @foreach($def['champs'] as $c)
                                        <div class="{{ $c['type'] === 'textarea' ? 'col-12' : 'col-md-4' }}">
                                            @include('projets.partials.volet_champ', ['c' => $c, 'valeur' => '', 'id' => $uid.'-'.$cle.'-n-'.$c['name']])
                                        </div>
                                    @endforeach
                                </div>
                                <button class="btn btn-sm btn-primary mt-3">Enregistrer</button>
                            </form>
                        </div>
                    @endif
                @endunless
            </div>
        </div>
    </div>

    @unless($lectureSeule)
        @foreach($lignes as $ligne)
            <div class="modal fade" id="{{ $uid }}-{{ $cle }}-edit-{{ $ligne->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg"><div class="modal-content">
                    <form method="POST" action="{{ route('fiche.update', [$cle, $ligne->id]) }}">
                        @csrf @method('PUT')
                        <div class="modal-header"><h5 class="modal-title">Modifier : {{ $def['singulier'] }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body"><div class="row g-2">
                            @foreach($def['champs'] as $c)
                                <div class="{{ $c['type'] === 'textarea' ? 'col-12' : 'col-md-6' }}">
                                    @include('projets.partials.volet_champ', ['c' => $c, 'valeur' => $ligne->{$c['name']}, 'id' => $uid.'-'.$cle.'-e'.$ligne->id.'-'.$c['name']])
                                </div>
                            @endforeach
                        </div></div>
                        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary">Enregistrer</button></div>
                    </form>
                </div></div>
            </div>
        @endforeach
    @endunless
@endforeach
</div>
