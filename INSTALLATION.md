# SGSPIP — Système Intégré de Gestion et de Suivi des Projets d'Investissement Public

Application web développée avec **Laravel** conformément au cahier des charges fourni
(19 entités, gestion administrative, planification, gestion financière, suivi-évaluation,
gestion documentaire, tableau de bord et cartographie).

Ce dossier contient uniquement le **code source applicatif** (app/, database/, routes/,
resources/views/, bootstrap/app.php, composer.json). Il doit être fusionné avec un
squelette Laravel fraîchement installé (le squelette officiel fournit `vendor/`,
`config/`, le reste de `storage/`, etc., qui ne sont pas inclus ici pour garder
l'archive légère).

## 1. Prérequis

- PHP >= 8.2 avec les extensions usuelles (mbstring, openssl, pdo_mysql, tokenizer, xml, ctype, json, bcmath, fileinfo)
- Composer
- MySQL >= 8.0 (ou MariaDB équivalent)
- Node.js + npm (pour Vite, facultatif si vous utilisez les CDN déjà intégrés aux vues)

## 2. Installation pas à pas

```bash
# 1. Créer un projet Laravel vierge (télécharge le framework et ses dépendances)
composer create-project laravel/laravel sgspip
cd sgspip

# 2. Copier le contenu de cette archive PAR-DESSUS le projet fraîchement créé
#    (remplacez ces dossiers/fichiers par ceux fournis) :
#    - app/
#    - database/
#    - routes/
#    - resources/views/
#    - bootstrap/app.php
#    - composer.json  (fusionner si vous avez déjà des dépendances ajoutées)

# 3. Réinstaller les dépendances (au cas où composer.json a changé)
composer install

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Créer la base de données MySQL "sgspip" puis renseigner
#    DB_DATABASE, DB_USERNAME, DB_PASSWORD dans le fichier .env

# 6. Lancer les migrations et les données de démonstration
php artisan migrate --seed

# 7. Créer le lien symbolique de stockage public (rapports, pièces justificatives)
php artisan storage:link

# 8. Démarrer le serveur de développement
php artisan serve
```

L'application est ensuite accessible sur **http://localhost:8000**, qui redirige
automatiquement vers la page de connexion.

## 3. Comptes de démonstration

Tous les comptes ci-dessous ont pour mot de passe : `Jeanmarc110`

| Rôle | E-mail |
|---|---|
| Administrateur | i.hien@plan.gouv.ci (HIEN TOTO) |
| Gestionnaire de projets | i.gbane@plan.gouv.ci (GBANE) |
| Responsable financier | i.diarra@plan.gouv.ci (DIARRASSOUBA) |
| Responsable suivi-évaluation | i.yapo@plan.gouv.ci (YAPO) |
| Utilisateur consultant | i.bohoussou@plan.gouv.ci (BOHOUSSOU) |

## 4. Contenu fonctionnel livré

- **Authentification** : connexion / déconnexion, contrôle d'accès par rôle (middleware `role`)
- **19 entités** conformes à la section 7 du cahier des charges, avec CRUD complet pour
  chacune (Utilisateur, Structure, Type_Structure, Projet, Secteur, Zone de localisation,
  Bailleur, Type_Bailleur, Financement, Décaissement, Dépense, Activité, Tâche, Indicateur,
  Rapport, Pièce justificative, Fiche PIP, Programme, État)
- **Tableau de bord** avec statistiques globales, répartition par secteur et **carte
  interactive** (Leaflet/OpenStreetMap) des projets par zone de localisation
- **Recherche multicritère** (référence, secteur, structure, bailleur, zone, statut, période)
- **Gestion des fiches PIP** avec association multiple aux projets
- **Suivi financier** : financements (bailleur **ou** État comme acteur institutionnel),
  décaissements, dépenses, avec comparaison engagé / décaissé / dépensé par projet
- **Suivi des activités, tâches et indicateurs** directement depuis la fiche projet
- **Rapports** avec upload de fichier (PDF, DOC, DOCX, XLS, XLSX) et téléchargement
- **Pièces justificatives** avec catégorisation (facture, reçu, contrat, PV, autre) et upload
- **Gestion des utilisateurs** réservée à l'administrateur

## 5. Notes techniques

- Base de données : MySQL, migrations Laravel (voir `database/migrations`)
- ORM : Eloquent, avec relations conformes à la section 8 (relations principales) et aux
  règles de gestion RG01 à RG19 du cahier des charges
- L'entité **Fiche PIP ↔ Projet** est une relation many-to-many (table pivot `fiche_pip_projet`)
- L'entité **Financement** peut être rattachée soit à un **Bailleur**, soit à l'**État**
  (acteur institutionnel du financement public — RG19), via les colonnes nullables
  `bailleur_id` / `etat_id`
- Aucune entité « Budget » ou « Document » indépendante n'a été introduite : la gestion
  documentaire est bien portée par l'entité **Pièce justificative**, conformément à la section 13
- Mots de passe hachés (bcrypt via `Hash::make`), validation des formulaires côté serveur,
  suppressions contrôlées (empêchées lorsque des enregistrements dépendants existent)

## 6. Prochaines étapes suggérées pour la soutenance

- Générer le MCD / MLD / MPD à partir des migrations (un export peut être produit avec un
  outil de modélisation à partir de la section 13 du cahier des charges)
- Ajouter le dictionnaire de données (types, contraintes) à partir des migrations fournies
- Personnaliser la page de connexion avec les armoiries de la Côte d'Ivoire et le logo du
  Ministère de l'Économie, du Plan et du Développement (emplacements prévus dans
  `resources/views/auth/login.blade.php`)
