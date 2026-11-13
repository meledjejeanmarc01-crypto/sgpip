{{-- Synthèse des charges récurrentes par année. Variable : $lignes (charges récurrentes du projet) --}}
@php
    $code = function ($categorie) {
        $t = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii((string) $categorie));
        return str_contains($t, 'fonction') ? 'F' : (str_contains($t, 'entretien') ? 'E' : (str_contains($t, 'recouvr') ? 'R' : null));
    };
    $anneesCharges = $lignes->pluck('annee')->unique()->sort()->values();
    $somme = fn ($c, $a) => (float) $lignes->filter(fn ($l) => $l->annee == $a && $code($l->categorie) === $c)->sum('montant');
    $f = fn ($v) => number_format($v, 0, ',', ' ');
    $totalCategorie = fn ($c) => (float) $lignes->filter(fn ($l) => $code($l->categorie) === $c)->sum('montant');
@endphp
<div class="table-responsive mb-3">
    <table class="table table-sm table-bordered align-middle mb-0 text-end">
        <thead class="table-light"><tr>
            <th class="text-start">Charges récurrentes</th>
            @foreach($anneesCharges as $a)<th>{{ $a }}</th>@endforeach
            <th>Total</th>
        </tr></thead>
        <tbody>
            <tr><td class="text-start">Coûts de fonctionnement (a)</td>
                @foreach($anneesCharges as $a)<td>{{ $f($somme('F', $a)) }}</td>@endforeach
                <td class="fw-semibold">{{ $f($totalCategorie('F')) }}</td></tr>
            <tr><td class="text-start">Entretien (d)</td>
                @foreach($anneesCharges as $a)<td>{{ $f($somme('E', $a)) }}</td>@endforeach
                <td class="fw-semibold">{{ $f($totalCategorie('E')) }}</td></tr>
            <tr class="table-light fw-semibold"><td class="text-start">Total des charges récurrentes brutes (g = a + d)</td>
                @foreach($anneesCharges as $a)<td>{{ $f($somme('F', $a) + $somme('E', $a)) }}</td>@endforeach
                <td>{{ $f($totalCategorie('F') + $totalCategorie('E')) }}</td></tr>
            <tr><td class="text-start">Recouvrement des charges récurrentes (h)</td>
                @foreach($anneesCharges as $a)<td>{{ $f($somme('R', $a)) }}</td>@endforeach
                <td class="fw-semibold">{{ $f($totalCategorie('R')) }}</td></tr>
            <tr class="table-light fw-semibold"><td class="text-start">Charges récurrentes à couvrir (i = g - h)</td>
                @foreach($anneesCharges as $a)<td>{{ $f($somme('F', $a) + $somme('E', $a) - $somme('R', $a)) }}</td>@endforeach
                <td>{{ $f($totalCategorie('F') + $totalCategorie('E') - $totalCategorie('R')) }}</td></tr>
        </tbody>
    </table>
</div>
