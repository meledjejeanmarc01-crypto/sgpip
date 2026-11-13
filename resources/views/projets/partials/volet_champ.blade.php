{{-- Champ d'un volet de la fiche projet. Variables : $c (définition du champ), $valeur, $id (identifiant HTML unique), $optionsProjet --}}
@php $req = ($c['required'] ?? false); @endphp
<label class="form-label small mb-1" for="{{ $id }}">{{ $c['label'] }}@if($req) <span class="text-danger">*</span>@endif</label>
@if($c['type'] === 'textarea')
    <textarea id="{{ $id }}" name="{{ $c['name'] }}" rows="2" class="form-control form-control-sm" @required($req)>{{ $valeur }}</textarea>
@elseif($c['type'] === 'select')
    <select id="{{ $id }}" name="{{ $c['name'] }}" class="form-select form-select-sm" @required($req)>
        <option value="">-- Choisir --</option>
        @foreach($c['options'] as $val => $lib)<option value="{{ $val }}" @selected((string) $valeur === (string) $val)>{{ $lib }}</option>@endforeach
    </select>
@elseif(isset($optionsProjet[$c['type']]))
    {{-- marche, financement, activite, composante : liste des éléments du projet --}}
    <select id="{{ $id }}" name="{{ $c['name'] }}" class="form-select form-select-sm" @required($req)>
        <option value="">-- Choisir --</option>
        @foreach($optionsProjet[$c['type']] as $val => $lib)<option value="{{ $val }}" @selected((string) $valeur === (string) $val)>{{ $lib }}</option>@endforeach
    </select>
@elseif($c['type'] === 'year')
    <input id="{{ $id }}" type="number" name="{{ $c['name'] }}" value="{{ $valeur }}" min="2000" max="2100" class="form-control form-control-sm" @required($req)>
@elseif($c['type'] === 'number')
    <input id="{{ $id }}" type="number" step="0.01" min="0" @if(isset($c['max'])) max="{{ $c['max'] }}" @endif name="{{ $c['name'] }}" value="{{ $valeur }}" class="form-control form-control-sm" @required($req)>
@else
    <input id="{{ $id }}" type="text" name="{{ $c['name'] }}" value="{{ $valeur }}" class="form-control form-control-sm" @required($req)>
@endif
