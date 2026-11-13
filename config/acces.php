<?php

/*
|--------------------------------------------------------------------------
| Droits d'accès par rôle  (cahier des charges §6)
|--------------------------------------------------------------------------
|
| UNE SEULE source de vérité pour toute l'application : les routes
| (middleware « acces »), le menu et les boutons des vues lisent ce fichier.
|
| Trois rôles (colonne users.role) :
|   - administrateur        : tous les droits
|   - gestionnaire_projet   : modifie uniquement les projets qu'il gère
|                             (table projet_user) et leurs éléments
|   - consultant            : consultation seule
|
| Un « module » correspond au premier segment du nom de route
| (ex. « financements » pour financements.index / financements.edit…).
| Pour chaque module :
|   'voir'     : rôles autorisés à ouvrir les pages de consultation
|                (index, show, téléchargements…)
|   'modifier' : rôles autorisés à créer / modifier / supprimer
|                (pages create et edit comprises, et toute requête POST/PUT/DELETE)
|
| Valeurs possibles : '*' (tous les rôles connectés), [] (personne), ou une liste de rôles.
| Un module absent de ce fichier est REFUSÉ à tout le monde (sécurité par défaut) :
| lorsque vous ajoutez de nouvelles routes, ajoutez aussi leur module ici.
|
| Pour les modules rattachés à un projet, « modifier » donne le droit de principe ;
| le contrôle « ce projet fait-il partie de ceux que je gère ? » est ensuite fait
| par le middleware « projet.acces ».
|
*/

$admin = ['administrateur'];
$gestion = ['administrateur', 'gestionnaire_projet'];

return [

    'modules' => [

        // Pages communes à tous les utilisateurs connectés
        'dashboard' => ['voir' => '*', 'modifier' => []],
        'mot-de-passe' => ['voir' => '*', 'modifier' => '*'],
        'notifications' => ['voir' => '*', 'modifier' => '*'],

        // Projets et tout ce qui s'y rattache : lecture pour tous, écriture sur ses projets
        'projets' => ['voir' => '*', 'modifier' => $gestion],
        'fiche' => ['voir' => '*', 'modifier' => $gestion],
        'activites' => ['voir' => '*', 'modifier' => $gestion],
        'taches' => ['voir' => '*', 'modifier' => $gestion],
        'indicateurs' => ['voir' => '*', 'modifier' => $gestion],
        'composantes' => ['voir' => '*', 'modifier' => $gestion],
        'risques' => ['voir' => '*', 'modifier' => $gestion],
        'parties-prenantes' => ['voir' => '*', 'modifier' => $gestion],
        'etudes' => ['voir' => '*', 'modifier' => $gestion],
        'objectifs-specifiques' => ['voir' => '*', 'modifier' => $gestion],
        'resultats-attendus' => ['voir' => '*', 'modifier' => $gestion],
        'analyses-causales' => ['voir' => '*', 'modifier' => $gestion],
        'documents' => ['voir' => '*', 'modifier' => $gestion],
        'acteurs' => ['voir' => '*', 'modifier' => $gestion],

        // Gestion financière
        'financements' => ['voir' => '*', 'modifier' => $gestion],
        'conventions-financement' => ['voir' => '*', 'modifier' => $gestion],
        'decaissements' => ['voir' => '*', 'modifier' => $gestion],
        'depenses' => ['voir' => '*', 'modifier' => $gestion],
        'situation-financiere' => ['voir' => '*', 'modifier' => []],

        // Suivi-évaluation
        'rapports' => ['voir' => '*', 'modifier' => $gestion],

        // Planification et référentiels : lecture pour tous, écriture réservée à l'administrateur
        'programmes' => ['voir' => '*', 'modifier' => $admin],
        'axes' => ['voir' => '*', 'modifier' => $admin],
        'fiches-pip' => ['voir' => '*', 'modifier' => $admin],
        'reformes' => ['voir' => '*', 'modifier' => $admin],
        'structures' => ['voir' => '*', 'modifier' => $admin],
        'types-structure' => ['voir' => '*', 'modifier' => $admin],
        'secteurs' => ['voir' => '*', 'modifier' => $admin],
        'zones' => ['voir' => '*', 'modifier' => $admin],
        'localisation' => ['voir' => '*', 'modifier' => $admin],
        'bailleurs' => ['voir' => '*', 'modifier' => $admin],
        'types-bailleur' => ['voir' => '*', 'modifier' => $admin],
        'pays-etrangers' => ['voir' => '*', 'modifier' => $admin],
        'actions-pnd' => ['voir' => '*', 'modifier' => $admin],
        'types-document' => ['voir' => '*', 'modifier' => $admin],
        'types-partie-prenante' => ['voir' => '*', 'modifier' => $admin],
        'types-analyse-causale' => ['voir' => '*', 'modifier' => $admin],
        'groupes-acteur' => ['voir' => '*', 'modifier' => $admin],

        // Administration des comptes : l'administrateur seul voit et modifie
        'utilisateurs' => ['voir' => $admin, 'modifier' => $admin],
    ],

];
