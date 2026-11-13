<?php

use App\Http\Controllers\ActionPndController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\ActeurController;
use App\Http\Controllers\AnalyseCausaleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AxeController;
use App\Http\Controllers\BailleurController;
use App\Http\Controllers\ComposanteController;
use App\Http\Controllers\ConventionFinancementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FicheVoletController;
use App\Http\Controllers\DecaissementController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EtudeController;
use App\Http\Controllers\FichePipController;
use App\Http\Controllers\FinancementController;
use App\Http\Controllers\GroupeActeurController;
use App\Http\Controllers\IndicateurController;
use App\Http\Controllers\LocalisationAdminController;
use App\Http\Controllers\LocalisationController;
use App\Http\Controllers\MotDePasseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ObjectifSpecifiqueController;
use App\Http\Controllers\PartiePrenanteController;
use App\Http\Controllers\PaysEtrangerController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\ReformeController;
use App\Http\Controllers\ResultatAttenduController;
use App\Http\Controllers\RisqueController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\SituationFinanciereController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\TypeBailleurController;
use App\Http\Controllers\TypeAnalyseCausaleController;
use App\Http\Controllers\TypeDocumentController;
use App\Http\Controllers\TypePartiePrenanteController;
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
Route::post('/connexion', [AuthController::class, 'login'])->name('login.submit')->middleware('throttle:5,1');
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Routes protégées (utilisateur authentifié)
|--------------------------------------------------------------------------
| - acces        : droits par rôle et par module (config/acces.php) :
|                  consultant en lecture seule, référentiels réservés à l'administrateur...
| - projet.acces : un gestionnaire ne modifie que les projets qu'il gère
|                  (et leurs éléments : activités, tâches, financements...)
*/
Route::middleware(['auth', 'acces', 'projet.acces'])->group(function () {

    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion du mot de passe et notifications de l'utilisateur connecté
    Route::get('/mon-mot-de-passe', [MotDePasseController::class, 'edit'])->name('mot-de-passe.edit');
    Route::put('/mon-mot-de-passe', [MotDePasseController::class, 'update'])->name('mot-de-passe.update');
    Route::get('/situation-financiere', [SituationFinanciereController::class, 'index'])->name('situation-financiere.index');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/lues', [NotificationController::class, 'marquerLues'])->name('notifications.lues');

    // Gestion des projets (entité centrale) - lecture pour tous les rôles authentifiés.
    // Le consultant est bloqué en écriture par le middleware acces (config/acces.php) ;
    // le contrôle "projet géré par l'utilisateur" est fait par projet.acces + ProjetPolicy.
    Route::get('/projets/carte', [ProjetController::class, 'carte'])->name('projets.carte');
    Route::resource('projets', ProjetController::class);

    // Circuit de validation du projet (§9.4)
    // Soumettre : administrateur ou gestionnaire du projet. Valider / rejeter : administrateur seulement.
    Route::post('/projets/{projet}/soumettre', [ProjetController::class, 'soumettre'])->name('projets.soumettre')->middleware('role:administrateur,gestionnaire_projet');
    Route::post('/projets/{projet}/valider', [ProjetController::class, 'valider'])->name('projets.valider')->middleware('role:administrateur');
    Route::post('/projets/{projet}/rejeter', [ProjetController::class, 'rejeter'])->name('projets.rejeter')->middleware('role:administrateur');

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

    // Composantes / Risques / Parties prenantes / Études / Objectifs spécifiques, imbriqués sous Projet
    Route::post('/projets/{projet}/composantes', [ComposanteController::class, 'store'])->name('composantes.store');
    Route::put('/composantes/{composante}', [ComposanteController::class, 'update'])->name('composantes.update');
    Route::delete('/composantes/{composante}', [ComposanteController::class, 'destroy'])->name('composantes.destroy');

    // Volets de la fiche projet (bénéficiaires, emplois, comités, charges, budgets, marchés, AE-CP, critères)
    // Attention : update/destroy reçoivent un simple {id} (pas un modèle) ;
    // le contrôle du projet doit être fait dans FicheVoletController.
    Route::post('/projets/{projet}/fiche/{volet}', [FicheVoletController::class, 'store'])->where('volet', '[a-z_]+')->name('fiche.store');
    Route::put('/fiche/{volet}/{id}', [FicheVoletController::class, 'update'])->where('volet', '[a-z_]+')->whereNumber('id')->name('fiche.update');
    Route::delete('/fiche/{volet}/{id}', [FicheVoletController::class, 'destroy'])->where('volet', '[a-z_]+')->whereNumber('id')->name('fiche.destroy');

    Route::post('/projets/{projet}/risques', [RisqueController::class, 'store'])->name('risques.store');
    Route::put('/risques/{risque}', [RisqueController::class, 'update'])->name('risques.update');
    Route::delete('/risques/{risque}', [RisqueController::class, 'destroy'])->name('risques.destroy');

    Route::post('/projets/{projet}/parties-prenantes', [PartiePrenanteController::class, 'store'])->name('parties-prenantes.store');
    Route::put('/parties-prenantes/{partie_prenante}', [PartiePrenanteController::class, 'update'])->name('parties-prenantes.update');
    Route::delete('/parties-prenantes/{partie_prenante}', [PartiePrenanteController::class, 'destroy'])->name('parties-prenantes.destroy');

    Route::post('/projets/{projet}/etudes', [EtudeController::class, 'store'])->name('etudes.store');
    Route::put('/etudes/{etude}', [EtudeController::class, 'update'])->name('etudes.update');
    Route::delete('/etudes/{etude}', [EtudeController::class, 'destroy'])->name('etudes.destroy');

    Route::post('/projets/{projet}/objectifs-specifiques', [ObjectifSpecifiqueController::class, 'store'])->name('objectifs-specifiques.store');
    Route::put('/objectifs-specifiques/{objectif_specifique}', [ObjectifSpecifiqueController::class, 'update'])->name('objectifs-specifiques.update');
    Route::delete('/objectifs-specifiques/{objectif_specifique}', [ObjectifSpecifiqueController::class, 'destroy'])->name('objectifs-specifiques.destroy');

    Route::post('/objectifs-specifiques/{objectif_specifique}/resultats-attendus', [ResultatAttenduController::class, 'store'])->name('resultats-attendus.store');
    Route::put('/resultats-attendus/{resultat_attendu}', [ResultatAttenduController::class, 'update'])->name('resultats-attendus.update');
    Route::delete('/resultats-attendus/{resultat_attendu}', [ResultatAttenduController::class, 'destroy'])->name('resultats-attendus.destroy');

    Route::post('/projets/{projet}/analyses-causales', [AnalyseCausaleController::class, 'store'])->name('analyses-causales.store');
    Route::put('/analyses-causales/{analyses_causale}', [AnalyseCausaleController::class, 'update'])->name('analyses-causales.update');
    Route::delete('/analyses-causales/{analyses_causale}', [AnalyseCausaleController::class, 'destroy'])->name('analyses-causales.destroy');

    // Documents
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/projets/{projet}/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/telecharger', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{document}/ouvrir', [DocumentController::class, 'open'])->name('documents.open');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Acteurs : un gestionnaire peut en créer et les rattacher à ses projets
    Route::resource('acteurs', ActeurController::class)->except(['show']);
    Route::post('/projets/{projet}/acteurs', [ActeurController::class, 'attacher'])->name('projets.acteurs.attacher');
    Route::delete('/projets/{projet}/acteurs/{acteur}', [ActeurController::class, 'detacher'])->name('projets.acteurs.detacher');

    // Convention de financement, imbriquée sous Financement
    Route::get('/conventions-financement', [ConventionFinancementController::class, 'index'])->name('conventions-financement.index');
    Route::post('/financements/{financement}/convention', [ConventionFinancementController::class, 'store'])->name('conventions-financement.store');
    Route::put('/conventions-financement/{convention_financement}', [ConventionFinancementController::class, 'update'])->name('conventions-financement.update');
    Route::delete('/conventions-financement/{convention_financement}', [ConventionFinancementController::class, 'destroy'])->name('conventions-financement.destroy');

    // Gestion financière (le projet concerné vient du formulaire : contrôle à faire dans les contrôleurs)
    Route::resource('financements', FinancementController::class)->except(['show']);
    Route::resource('decaissements', DecaissementController::class)->except(['show']);
    Route::resource('depenses', DepenseController::class)->except(['show']);

    // Suivi-évaluation
    Route::resource('rapports', RapportController::class);
    Route::get('/rapports/{rapport}/telecharger', [RapportController::class, 'download'])->name('rapports.download');

    /*
    |--------------------------------------------------------------------------
    | Référentiels et planification
    | Les droits (lecture pour tous, écriture réservée à l'administrateur) sont définis
    | dans config/acces.php, module par module (middleware « acces »).
    |--------------------------------------------------------------------------
    */
    Route::resource('types-document', TypeDocumentController::class)->parameters(['types-document' => 'type_document'])->except(['show']);
    Route::resource('actions-pnd', ActionPndController::class)->parameters(['actions-pnd' => 'action_pnd'])->except(['show']);
    Route::resource('pays-etrangers', PaysEtrangerController::class)->parameters(['pays-etrangers' => 'pays_etranger'])->except(['show']);
    Route::resource('types-partie-prenante', TypePartiePrenanteController::class)->parameters(['types-partie-prenante' => 'type_partie_prenante'])->except(['show']);
    Route::resource('types-analyse-causale', TypeAnalyseCausaleController::class)->parameters(['types-analyse-causale' => 'type_analyse_causale'])->except(['show']);
    Route::resource('groupes-acteur', GroupeActeurController::class)->parameters(['groupes-acteur' => 'groupe_acteur'])->except(['show']);

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

    // Hiérarchie géographique : District > Région > Département > Commune > Sous-préfecture > Village
    // (table unique "localisations" avec niveau et parent). Les zones d'exécution sont sur /zones.
    Route::get('/localisation', [LocalisationAdminController::class, 'index'])->name('localisation.index');
    Route::post('/localisation', [LocalisationAdminController::class, 'store'])->name('localisation.store');
    Route::delete('/localisation/{localisation}', [LocalisationAdminController::class, 'destroy'])->name('localisation.destroy');
    Route::get('/localisation/niveaux/{niveau}/localisations', [LocalisationController::class, 'parNiveau'])->name('localisation.par-niveau');

    // Bailleurs
    Route::resource('bailleurs', BailleurController::class);
    Route::resource('types-bailleur', TypeBailleurController::class)->parameters(['types-bailleur' => 'type_bailleur'])->except(['show']);

    // Administration des utilisateurs (réservée à l'administrateur)
    Route::resource('utilisateurs', UtilisateurController::class)->except(['show'])->middleware('role:administrateur');
});
