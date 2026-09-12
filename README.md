# SGSPIP — Système de Gestion et de Suivi des Projets d'Investissement Public

Application web Laravel 13 réalisée d'après le cahier des charges SGSPIP
(Ministère du Plan et du Développement — Côte d'Ivoire).

## 1. Prérequis

- PHP >= 8.3 avec extensions : `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`
- Composer 2
- MySQL 8 (ou MariaDB) — une base nommée `sgspip`
- Node.js + npm (pour compiler les assets Vite)

## 2. Installation

```bash
cd sgspip

composer install

# Créer la base de données MySQL "sgspip" au préalable (phpMyAdmin, ligne de commande, etc.)
# Le fichier .env est déjà configuré pour MySQL (DB_DATABASE=sgspip, DB_USERNAME=root, DB_PASSWORD=)
# Adaptez DB_USERNAME / DB_PASSWORD si nécessaire.

php artisan migrate --seed

npm install
npm run build
# ou pendant le développement : npm run dev

php artisan serve
```

L'application est ensuite accessible sur http://127.0.0.1:8000 (redirige vers /login).

## 3. Compte de connexion par défaut

Un compte administrateur est créé automatiquement par le seeder :

- Email : `admin@sgspip.ci`
- Mot de passe : `password`

**Changez ce mot de passe dès la première connexion en production.**

Les rôles disponibles (table `roles`) sont : Administrateur, Gestionnaire de projets,
Responsable financier, Responsable suivi-évaluation, Consultant. Le middleware `role:...`
protège pour l'instant uniquement le module Utilisateurs (réservé à l'Administrateur) ;
vous pouvez l'appliquer à d'autres routes dans `routes/web.php` selon vos besoins
(ex. `role:Administrateur,Responsable financier` sur les routes financières).

## 4. Ce qui a été développé (état actuel)

- **Authentification** (connexion / déconnexion, comptes actifs/inactifs, contrôle de rôle)
- **Tableau de bord** : compteurs de projets, budgets/décaissements/dépenses, avancement moyen,
  répartition par statut, derniers projets
- **Projets** : CRUD complet, recherche et filtres multicritères (référence/intitulé, statut,
  structure, secteur, bailleur), localisation en cascade (District → Région → Département →
  Sous-préfecture/Commune → Localité) avec coordonnées GPS
- **Fiche projet détaillée** regroupant : bailleurs/financement, budgets, décaissements,
  dépenses, activités + tâches, indicateurs, documents (upload/téléchargement sécurisé PDF,
  DOC, DOCX, XLS, XLSX), rapports — ajout via formulaires en modales, suppression contrôlée
- **Données de référence** : CRUD Structures, Secteurs, Bailleurs
- **Utilisateurs** : CRUD (réservé aux administrateurs), association rôle + structure
- **Carte du territoire** : projets géolocalisés affichés sur une carte Leaflet/OpenStreetMap
- **Jeux de données (seeders)** : rôles, ~30 ministères ivoiriens, 20 secteurs, 5 bailleurs
  internationaux, un District/Région/Département/2 Sous-préfectures/2 Communes/5 Localités
  d'Abidjan (avec coordonnées GPS réelles), et le compte administrateur

## 5. Limites connues / pistes d'évolution (prochaines étapes suggérées)

Le cahier des charges est couvert dans ses grandes lignes ; quelques points restent
volontairement simplifiés faute de temps, à améliorer selon vos besoins réels :

1. **Autorisations fines** : seul le module Utilisateurs est restreint aux administrateurs.
   Les autres rôles (Gestionnaire de projets, Responsable financier, Responsable
   suivi-évaluation, Consultant) existent en base mais n'ont pas encore de règles
   d'accès différenciées sur chaque module (ex. le Consultant devrait être en lecture
   seule). À ajouter via le middleware `role:...` déjà en place sur les routes concernées.
2. **CRUD de la localisation administrative** (District/Région/Département/Sous-préfecture/
   Commune/Localité) : les données sont actuellement gérées uniquement par seeder. Une
   interface d'administration dédiée (comme pour Structures/Secteurs/Bailleurs) serait
   à ajouter si vous devez enrichir la couverture géographique au-delà d'Abidjan.
3. **Édition** des activités, tâches, indicateurs, budgets, décaissements et dépenses :
   pour l'instant seuls l'ajout et la suppression sont proposés depuis la fiche projet ;
   la modification se fait en supprimant/recréant. Des formulaires d'édition dédiés
   peuvent être ajoutés sur le même modèle que Structures/Secteurs/Bailleurs.
4. **Génération automatique des rapports** : le module Rapports permet actuellement une
   saisie manuelle (titre, type, données). Une génération automatique (calculs à partir
   des budgets/décaissements/dépenses, export PDF/Excel) reste à implémenter — le cahier
   des charges le mentionne explicitement en section 19 "Évolution du système".
5. **Exports PDF/Excel** des rapports et statistiques (mentionnés en évolution du système).
6. **Journalisation des opérations** (section 18 du cahier des charges) : non implémentée.
7. Les tests unitaires/fonctionnels (`tests/`) n'ont pas été écrits.

## 6. Notes techniques

- Deux bugs hérités de la session précédente ont été corrigés au démarrage de cette session :
  la migration `decaissements` était vide (incompatible avec le modèle), et le modèle
  `Structure` n'avait aucun champ déclaré. Le seeder de localisation (`LocalisationSeeder`)
  existait déjà avec des données réelles mais n'était jamais appelé par `DatabaseSeeder` — 
  c'est corrigé également.
- Le code n'a pas pu être exécuté ni testé avec un interpréteur PHP réel (environnement de
  génération sans PHP/Composer). La syntaxe de tous les fichiers `.php` a été vérifiée avec un
  parseur PHP automatisé (0 erreur de syntaxe détectée) et les routes nommées utilisées dans les
  vues ont été confrontées à celles définies. Testez avec `php artisan serve` et signalez-moi
  toute erreur : je corrigerai immédiatement.
