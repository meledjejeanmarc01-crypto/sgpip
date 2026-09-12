<?php

use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AxeController;
use App\Http\Controllers\BailleurController;
use App\Http\Controllers\ChargeRecurrenteController;
use App\Http\Controllers\CibleController;
use App\Http\Controllers\ComposanteController;
use App\Http\Controllers\ConventionFinancementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DecaissementController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\EtudeController;
use App\Http\Controllers\FichePipController;
use App\Http\Controllers\FinancementController;
use App\Http\Controllers\IndicateurController;
use App\Http\Controllers\MarcheController;
use App\Http\Controllers\ObjectifSpecifiqueController;
use App\Http\Controllers\PartiePrenanteController;
use App\Http\Controllers\PieceJustificativeController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\ReformeController;
use App\Http\Controllers\RisqueController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\TypeBailleurController;
use App\Http\Controllers\TypeStructureController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\ZoneLocalisationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/connexion', [AuthController::class, 'login'])->name('login.submit');
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Routes protégées (utilisateur authentifié)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des projets (entité centrale) - accessible en lecture à tous les rôles authentifiés
    Route::resource('projets', ProjetController::class)
        ->middleware([
            'store' => 'role:administrateur,gestionnaire_projet',
            'update' => 'role:administrateur,gestionnaire_projet',
            'destroy' => 'role:administrateur,gestionnaire_projet',
        ]);

    // Activités / Tâches / Indicateurs, imbriqués sous Projet
    Route::post('/projets/{projet}/activites', [ActiviteController::class, 'store'])->name('activites.store');
    Route::put('/activites/{activite}', [ActiviteController::class, 'update'])->name('activites.update');
    Route::delete('/activites/{activite}', [ActiviteController::class, 'destroy'])->name('activites.destroy');

    Route::post('/activites/{activite}/taches', [TacheController::class, 'store'])->name('taches.store');
    Route::put('/taches/{tache}', [TacheController::class, 'update'])->name('taches.update');
    Route::delete('/taches/{tache}', [TacheController::class, 'destroy'])->name('taches.destroy');

    Route::post('/activites/{activite}/indicateurs', [IndicateurController::class, 'store'])->name('indicateurs.store');
    Route::put('/indicateurs/{indicateur}', [IndicateurController::class, 'update'])->name('indicateurs.update');
    Route::delete('/indicateurs/{indicateur}', [IndicateurController::class, 'destroy'])->name('indicateurs.destroy');

    // Composantes / Risques / Parties prenantes / Cibles / Études / Charges récurrentes / Marchés / Objectifs spécifiques, imbriqués sous Projet
    Route::post('/projets/{projet}/composantes', [ComposanteController::class, 'store'])->name('composantes.store');
    Route::put('/composantes/{composante}', [ComposanteController::class, 'update'])->name('composantes.update');
    Route::delete('/composantes/{composante}', [ComposanteController::class, 'destroy'])->name('composantes.destroy');

    Route::post('/projets/{projet}/risques', [RisqueController::class, 'store'])->name('risques.store');
    Route::put('/risques/{risque}', [RisqueController::class, 'update'])->name('risques.update');
    Route::delete('/risques/{risque}', [RisqueController::class, 'destroy'])->name('risques.destroy');

    Route::post('/projets/{projet}/parties-prenantes', [PartiePrenanteController::class, 'store'])->name('parties-prenantes.store');
    Route::put('/parties-prenantes/{partie_prenante}', [PartiePrenanteController::class, 'update'])->name('parties-prenantes.update');
    Route::delete('/parties-prenantes/{partie_prenante}', [PartiePrenanteController::class, 'destroy'])->name('parties-prenantes.destroy');

    Route::post('/projets/{projet}/cibles', [CibleController::class, 'store'])->name('cibles.store');
    Route::put('/cibles/{cible}', [CibleController::class, 'update'])->name('cibles.update');
    Route::delete('/cibles/{cible}', [CibleController::class, 'destroy'])->name('cibles.destroy');

    Route::post('/projets/{projet}/etudes', [EtudeController::class, 'store'])->name('etudes.store');
    Route::put('/etudes/{etude}', [EtudeController::class, 'update'])->name('etudes.update');
    Route::delete('/etudes/{etude}', [EtudeController::class, 'destroy'])->name('etudes.destroy');

    Route::post('/projets/{projet}/charges-recurrentes', [ChargeRecurrenteController::class, 'store'])->name('charges-recurrentes.store');
    Route::put('/charges-recurrentes/{charge_recurrente}', [ChargeRecurrenteController::class, 'update'])->name('charges-recurrentes.update');
    Route::delete('/charges-recurrentes/{charge_recurrente}', [ChargeRecurrenteController::class, 'destroy'])->name('charges-recurrentes.destroy');

    Route::post('/projets/{projet}/marches', [MarcheController::class, 'store'])->name('marches.store');
    Route::put('/marches/{marche}', [MarcheController::class, 'update'])->name('marches.update');
    Route::delete('/marches/{marche}', [MarcheController::class, 'destroy'])->name('marches.destroy');

    Route::post('/projets/{projet}/objectifs-specifiques', [ObjectifSpecifiqueController::class, 'store'])->name('objectifs-specifiques.store');
    Route::put('/objectifs-specifiques/{objectif_specifique}', [ObjectifSpecifiqueController::class, 'update'])->name('objectifs-specifiques.update');
    Route::delete('/objectifs-specifiques/{objectif_specifique}', [ObjectifSpecifiqueController::class, 'destroy'])->name('objectifs-specifiques.destroy');

    // Convention de financement, imbriquée sous Financement
    Route::post('/financements/{financement}/convention', [ConventionFinancementController::class, 'store'])->name('conventions-financement.store');
    Route::put('/conventions-financement/{convention_financement}', [ConventionFinancementController::class, 'update'])->name('conventions-financement.update');
    Route::delete('/conventions-financement/{convention_financement}', [ConventionFinancementController::class, 'destroy'])->name('conventions-financement.destroy');

    // Association Fiches PIP <-> Projets
    Route::post('/fiches-pip/{fiche_pip}/projets', [FichePipController::class, 'associerProjets'])->name('fiches-pip.associer');

    // Planification : programmes, axes, fiches PIP
    Route::resource('programmes', ProgrammeController::class);
    Route::post('/programmes/{programme}/axes', [AxeController::class, 'store'])->name('axes.store');
    Route::put('/axes/{axe}', [AxeController::class, 'update'])->name('axes.update');
    Route::delete('/axes/{axe}', [AxeController::class, 'destroy'])->name('axes.destroy');
    Route::resource('fiches-pip', FichePipController::class)->parameters(['fiches-pip' => 'fiche_pip']);

    // Feuille de route : réformes
    Route::resource('reformes', ReformeController::class);

    // Référentiels administratifs
    Route::resource('structures', StructureController::class);
    Route::resource('types-structure', TypeStructureController::class)->parameters(['types-structure' => 'type_structure'])->except(['show']);
    Route::resource('secteurs', SecteurController::class)->except(['show']);
    Route::resource('zones', ZoneLocalisationController::class);
    Route::resource('etats', EtatController::class)->except(['show']);

    // Gestion financière
    Route::resource('bailleurs', BailleurController::class);
    Route::resource('types-bailleur', TypeBailleurController::class)->parameters(['types-bailleur' => 'type_bailleur'])->except(['show']);
    Route::resource('financements', FinancementController::class)
        ->except(['show'])
        ->middleware(['store' => 'role:administrateur,responsable_financier', 'update' => 'role:administrateur,responsable_financier', 'destroy' => 'role:administrateur,responsable_financier']);
    Route::resource('decaissements', DecaissementController::class)
        ->except(['show'])
        ->middleware(['store' => 'role:administrateur,responsable_financier', 'update' => 'role:administrateur,responsable_financier', 'destroy' => 'role:administrateur,responsable_financier']);
    Route::resource('depenses', DepenseController::class)
        ->except(['show'])
        ->middleware(['store' => 'role:administrateur,responsable_financier', 'update' => 'role:administrateur,responsable_financier', 'destroy' => 'role:administrateur,responsable_financier']);

    // Suivi-évaluation
    Route::resource('rapports', RapportController::class);
    Route::get('/rapports/{rapport}/telecharger', [RapportController::class, 'download'])->name('rapports.download');

    // Pièces justificatives
    Route::resource('pieces-justificatives', PieceJustificativeController::class)
        ->parameters(['pieces-justificatives' => 'piece'])
        ->only(['index', 'create', 'store', 'destroy']);
    Route::get('/pieces-justificatives/{piece}/telecharger', [PieceJustificativeController::class, 'download'])->name('pieces-justificatives.download');

    // Administration des utilisateurs (réservée à l'administrateur)
    Route::resource('utilisateurs', UtilisateurController::class)->except(['show'])->middleware('role:administrateur');
});
