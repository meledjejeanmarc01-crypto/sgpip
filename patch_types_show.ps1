# Ajoute les listes de types (analyse causale, partie prenante) avec creation directe dans la fiche projet.
# A lancer depuis le dossier du projet (celui qui contient "artisan").
$f = "resources\views\projets\show.blade.php"
if (-not (Test-Path $f)) { Write-Host "Lancez ce script depuis le dossier du projet (sgspip)." -ForegroundColor Red; exit }
$t = Get-Content $f -Raw -Encoding UTF8
if ($t.Contains("types-analyse-causale.store")) { Write-Host "Deja installe : rien a faire." -ForegroundColor Yellow; exit }
Copy-Item $f ($f + ".sauvegarde2") -Force
Write-Host "Sauvegarde : $f.sauvegarde2"
function Remplacer($texte, $ancien, $nouveau, $nom) {
  if (-not $texte.Contains($ancien)) { Write-Host "INTROUVABLE : $nom" -ForegroundColor Red; return $texte }
  Write-Host "OK : $nom"
  return $texte.Replace($ancien, $nouveau)
}

$a1 = @'
<div class="col-md-4"><textarea name="probleme_identifie" class="form-control form-control-sm" rows="2" placeholder="Problème identifié" required></textarea></div>
'@
$n1 = @'
<div class="col-md-3">
                    <select name="type_analyse_causale_id" class="form-select form-select-sm" data-creer-url="{{ route('types-analyse-causale.store') }}" data-creer-nom="Nom du nouveau type d'analyse">
                        <option value="">Type d'analyse</option>
                        @foreach(\App\Models\TypeAnalyseCausale::orderBy('libelle')->get() as $tac)
                            <option value="{{ $tac->id }}">{{ $tac->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3"><textarea name="probleme_identifie" class="form-control form-control-sm" rows="2" placeholder="Problème identifié" required></textarea></div>
'@
$a2 = @'
<div class="col-md-4"><textarea name="effet" class="form-control form-control-sm" rows="2" placeholder="Effet" required></textarea></div>
'@
$n2 = @'
<div class="col-md-2"><textarea name="effet" class="form-control form-control-sm" rows="2" placeholder="Effet" required></textarea></div>
'@
$a3 = @'
<thead><tr><th>Problème identifié</th><th>Cause</th><th>Effet</th><th></th></tr></thead>
'@
$n3 = @'
<thead><tr><th>Type</th><th>Problème identifié</th><th>Cause</th><th>Effet</th><th></th></tr></thead>
'@
$a4 = @'
<td>{{ $ac->probleme_identifie ?: '—' }}</td>
'@
$n4 = @'
<td>{{ optional($ac->typeAnalyseCausale)->libelle ?: '—' }}</td>
                    <td>{{ $ac->probleme_identifie ?: '—' }}</td>
'@
$a5 = @'
<select name="type_partie_prenante_id" class="form-select form-select-sm">
'@
$n5 = @'
<select name="type_partie_prenante_id" class="form-select form-select-sm" data-creer-url="{{ route('types-partie-prenante.store') }}" data-creer-nom="Nom du nouveau type de partie prenante">
'@
$a6 = @'
<select name="type_partie_prenante_id" class="form-select">
'@
$n6 = @'
<select name="type_partie_prenante_id" class="form-select" data-creer-url="{{ route('types-partie-prenante.store') }}" data-creer-nom="Nom du nouveau type de partie prenante">
'@
$t = Remplacer $t $a1 $n1 "analyse causale : champ Type"
$t = Remplacer $t $a2 $n2 "analyse causale : largeur du champ Effet"
$t = Remplacer $t $a3 $n3 "analyse causale : colonne Type (en-tete)"
$t = Remplacer $t $a4 $n4 "analyse causale : colonne Type (cellule)"
$t = Remplacer $t $a5 $n5 "partie prenante : type (ajout)"
$t = Remplacer $t $a6 $n6 "partie prenante : type (modification)"
[System.IO.File]::WriteAllText((Resolve-Path $f).Path, $t, (New-Object System.Text.UTF8Encoding($false)))
Write-Host "Termine. Lancez maintenant : php artisan optimize:clear" -ForegroundColor Green
