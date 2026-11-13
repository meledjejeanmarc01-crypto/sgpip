# Remplace "Ministere de l'Economie, du Plan et du Developpement" par "Ministere du Plan et du Developpement"
# dans tout le projet (fichiers PHP, Blade, Markdown, JS, JSON, TXT, HTML).
#
# Utilisation, dans PowerShell, a la racine du projet (le dossier qui contient "artisan") :
#   .\remplacer_ministere.ps1             -> liste seulement les fichiers concernes (rien n'est modifie)
#   .\remplacer_ministere.ps1 -Appliquer  -> effectue le remplacement
#
# Si PowerShell refuse de lancer le script :
#   powershell -ExecutionPolicy Bypass -File .\remplacer_ministere.ps1 -Appliquer
param([switch]$Appliquer)

$utf8 = New-Object System.Text.UTF8Encoding($false)   # UTF-8 sans BOM (indispensable pour les fichiers PHP)

# Detecte aussi : "Economie" sans accent, apostrophe courbe, "Developpent" mal ecrit, majuscules
$motif = "(?i)Minist[\u00e8e]re\s+de\s+l['\u2019]?\s?[\u00e9e]conomie,?\s+du\s+Plan\s+et\s+du\s+D[\u00e9e]velopp(?:ement|ent)"

$normal    = "Minist" + [char]0x00E8 + "re du Plan et du D" + [char]0x00E9 + "veloppement"
$majuscule = "MINIST" + [char]0x00C8 + "RE DU PLAN ET DU D" + [char]0x00C9 + "VELOPPEMENT"
$bloc = {
    param($m)
    if ($m.Value -ceq $m.Value.ToUpperInvariant()) { $majuscule } else { $normal }
}
$evaluateur = [System.Text.RegularExpressions.MatchEvaluator]($bloc.GetNewClosure())

$racine = (Get-Location).Path
$exclus = '[\\/](vendor|node_modules|storage|\.git|cache)[\\/]|public[\\/]vendor|\.sauvegarde'
$extensions = '*.php', '*.md', '*.js', '*.json', '*.txt', '*.html'

$fichiers = @()
foreach ($d in 'app', 'resources', 'routes', 'database', 'config', 'public', 'lang') {
    if (Test-Path $d) {
        $fichiers += Get-ChildItem -Path $d -Recurse -File -Include $extensions -ErrorAction SilentlyContinue
    }
}
$fichiers += Get-ChildItem -Path '.\*' -File -Include '*.md', '*.txt' -ErrorAction SilentlyContinue

$total = 0
$nbFichiers = 0
foreach ($f in ($fichiers | Where-Object { $_.FullName -notmatch $exclus })) {
    $texte = [System.IO.File]::ReadAllText($f.FullName, [System.Text.Encoding]::UTF8)
    $n = [regex]::Matches($texte, $motif).Count
    if ($n -gt 0) {
        $total += $n
        $nbFichiers++
        Write-Host ("{0} : {1} occurrence(s)" -f $f.FullName.Substring($racine.Length + 1), $n)
        if ($Appliquer) {
            $nouveau = [regex]::Replace($texte, $motif, $evaluateur)
            [System.IO.File]::WriteAllText($f.FullName, $nouveau, $utf8)
        }
    }
}

Write-Host ""
if ($total -eq 0) {
    Write-Host "Aucune occurrence trouvee dans les fichiers du projet."
} elseif ($Appliquer) {
    Write-Host "$total occurrence(s) remplacee(s) dans $nbFichiers fichier(s). Lancez ensuite : php artisan optimize:clear"
} else {
    Write-Host "$total occurrence(s) dans $nbFichiers fichier(s). Relancez avec -Appliquer pour les remplacer."
}
