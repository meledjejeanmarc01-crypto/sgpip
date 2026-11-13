# Ajoute les onglets de la feuille PROGRAMMATION dans l'onglet Finances de la fiche projet.
# A lancer depuis le dossier du projet (celui qui contient "artisan").
$f = "resources\views\projets\show.blade.php"
if (-not (Test-Path $f)) { Write-Host "Lancez ce script depuis le dossier du projet (sgspip)." -ForegroundColor Red; exit }
$t = Get-Content $f -Raw -Encoding UTF8
if ($t.Contains("programmation_lf")) { Write-Host "Deja installe : rien a faire." -ForegroundColor Yellow; exit }
$base = "'budgets','marches','echeanciers','charges'"
$plan = ",'ventilations','plan_decaissement','plan_global','plan_detaille','plan_travail'"
$prog = ",'demande_financement','previsions_valeur','programmation_lf'"
if ($t.Contains($base + $plan)) { $ancien = $base + $plan } elseif ($t.Contains($base)) { $ancien = $base } else {
  Write-Host "INTROUVABLE : la ligne @include de l'onglet Finances (volets_nav). Copiez-moi cette ligne." -ForegroundColor Red; exit }
Copy-Item $f ($f + ".sauvegarde4") -Force
$t = $t.Replace($ancien, $ancien + $prog)
[System.IO.File]::WriteAllText((Resolve-Path $f).Path, $t, (New-Object System.Text.UTF8Encoding($false)))
Write-Host "OK : 3 onglets ajoutes a l'onglet Finances. Sauvegarde : $f.sauvegarde4" -ForegroundColor Green
Write-Host "Lancez maintenant : php artisan migrate  puis  php artisan optimize:clear"
