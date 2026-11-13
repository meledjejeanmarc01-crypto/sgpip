@extends('layouts.app')
@section('page-title', 'Modifier le financement')
@section('content')
<div class="card card-stat p-4" style="max-width:950px;">
    <h5 class="fw-bold mb-3">Modifier le financement</h5>
    <form method="POST" action="{{ route('financements.update', $financement) }}">
        @csrf @method('PUT')
        @include('financements.form')
        <div class="d-flex justify-content-center gap-3 mt-4">
            <button type="submit" class="btn btn-brand">Mettre à jour</button>
            <a href="{{ route('financements.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>

    @php
       $convention = $financement->conventionFinancement;
   @endphp
<div class="card card-stat p-4 mt-3" style="max-width:950px;">
    <h5 class="fw-bold mb-3">Convention de financement</h5>
    <form method="POST" action="{{ $convention ? route('conventions-financement.update', $convention) : route('conventions-financement.store', $financement) }}">
        @csrf
        @if($convention) @method('PUT') @endif
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Type d'accord</label>
                @php
                    $typesAccord = ['Convention', 'Protocole', 'Accord de financement', 'Contrat de financement'];
                    $accordActuel = old('type_accord', $convention->type_accord ?? '');
                @endphp
                <select name="type_accord" class="form-select">
                    <option value="">-- Choisir --</option>
                    @foreach($typesAccord as $ta)<option value="{{ $ta }}" @selected($accordActuel === $ta)>{{ $ta }}</option>@endforeach
                    @if($accordActuel && ! in_array($accordActuel, $typesAccord))<option value="{{ $accordActuel }}" selected>{{ $accordActuel }}</option>@endif
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nature du financement</label>
                <input type="text" name="nature_financement" value="{{ old('nature_financement', $convention->nature_financement ?? '') }}" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Date limite de tirage</label>
                <input type="date" name="date_limite_tirage" value="{{ old('date_limite_tirage', optional($convention->date_limite_tirage ?? null)->format('Y-m-d')) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Niveau d'avancement des négociations</label>
                @php
                    $niveauxNego = [
                        '1' => '1 - Accord de principe du bailleur',
                        '2' => '2 - Avis de non-objection du bailleur',
                        '3' => '3 - Convention de financement signée',
                        '4' => '4 - Accord de mise en vigueur',
                    ];
                    $niveauActuel = (string) old('niveau_avancement_negociations', $convention->niveau_avancement_negociations ?? '');
                @endphp
                <select name="niveau_avancement_negociations" class="form-select">
                    <option value="">-- Choisir --</option>
                    @foreach($niveauxNego as $val => $lib)<option value="{{ $val }}" @selected($niveauActuel === (string) $val)>{{ $lib }}</option>@endforeach
                    @if($niveauActuel !== '' && ! isset($niveauxNego[$niveauActuel]))<option value="{{ $niveauActuel }}" selected>{{ $niveauActuel }}</option>@endif
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">N° accord signé</label>
                <input type="text" name="numero_accord_signe" value="{{ old('numero_accord_signe', $convention->numero_accord_signe ?? '') }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Montant</label>
                <input type="number" step="0.01" name="montant" value="{{ old('montant', $convention->montant ?? '') }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Date de signature</label>
                <input type="date" name="date_signature" value="{{ old('date_signature', optional($convention->date_signature ?? null)->format('Y-m-d')) }}" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Engagement contractuel</label>
                @php $eng = old('engagement_contractuel', isset($convention) && ! is_null($convention->engagement_contractuel) ? (int) $convention->engagement_contractuel : ''); @endphp
                <select name="engagement_contractuel" class="form-select">
                    <option value="">-- Non précisé --</option>
                    <option value="1" @selected((string) $eng === '1')>Oui</option>
                    <option value="0" @selected((string) $eng === '0')>Non</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Date des négociations</label>
                <input type="date" name="date_avancement_negociations" value="{{ old('date_avancement_negociations', optional($convention->date_avancement_negociations ?? null)->format('Y-m-d')) }}" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Prorogation</label>
                @php $pro = old('proroge', isset($convention) && ! is_null($convention->proroge) ? (int) $convention->proroge : ''); @endphp
                <select name="proroge" class="form-select">
                    <option value="">-- Non précisé --</option>
                    <option value="1" @selected((string) $pro === '1')>Prorogé</option>
                    <option value="0" @selected((string) $pro === '0')>Non prorogé</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Durée de la prorogation (mois)</label>
                <input type="number" min="0" max="600" name="duree_prorogation_mois" value="{{ old('duree_prorogation_mois', $convention->duree_prorogation_mois ?? '') }}" class="form-control">
            </div>
        </div>
        {{-- Boutons centrés : « Supprimer » est dans cette rangée mais envoie le formulaire séparé ci-dessous (attribut form) --}}
        <div class="d-flex justify-content-center gap-3 mt-4">
            <button type="submit" class="btn btn-brand">{{ $convention ? 'Mettre à jour' : 'Enregistrer' }} la convention</button>
            @if($convention)
                <button type="submit" form="form-supprimer-convention" class="btn btn-outline-danger">Supprimer la convention</button>
            @endif
        </div>
    </form>
    @if($convention)
    <form id="form-supprimer-convention" action="{{ route('conventions-financement.destroy', $convention) }}" method="POST" class="d-none" onsubmit="return confirm('Supprimer cette convention de financement ?');">
        @csrf @method('DELETE')
    </form>
    @endif
</div>
@endsection
