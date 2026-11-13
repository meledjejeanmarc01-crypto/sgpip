# Ajoute les onglets de la feuille PLANIFICATION dans l'onglet Finances de la fiche projet.
# A lancer depuis le dossier du projet (celui qui contient "artisan").
$f = "resources\views\projets\show.blade.php"
if (-not (Test-Path $f)) { Write-Host "Lancez ce script depuis le dossier du projet (sgspip)." -ForegroundColor Red; exit }
$t = Get-Content $f -Raw -Encoding UTF8
if ($t.Contains("plan_detaille")) { Write-Host "Deja installe : rien a faire." -ForegroundColor Yellow; exit }
$ancien = "['budgets','marches','echeanciers','charges']"
$nouveau = "['budgets','marches','echeanciers','charges','ventilations','plan_decaissement','plan_global','plan_detaille','plan_travail']"
if (-not $t.Contains($ancien)) { Write-Host "INTROUVABLE : la ligne @include de l'onglet Finances (volets_nav). Copiez-moi cette ligne." -ForegroundColor Red; exit }
Copy-Item $f ($f + ".sauvegarde3") -Force
$t = $t.Replace($ancien, $nouveau)
[System.IO.File]::WriteAllText((Resolve-Path $f).Path, $t, (New-Object System.Text.UTF8Encoding($false)))
Write-Host "OK : 5 onglets ajoutes a l'onglet Finances. Sauvegarde : $f.sauvegarde3" -ForegroundColor Green
Write-Host "Lancez maintenant : php artisan migrate  puis  php artisan optimize:clear"
