# Application de réservation de places de cinéma (PHP MVC)

Ce projet est une petite application de réservation de places de cinéma en PHP sans framework, avec une architecture MVC et une base MySQL.

## Installation

1. **Cloner / copier le projet** dans votre dossier web (ex: `C:\xampp\htdocs\Pathehp` ou équivalent).
2. **Créer la base de données** MySQL :
   - Ouvrir votre client MySQL (phpMyAdmin, CLI, etc.)
   - Importer le script `sql/database.sql`.
3. **Configurer l’accès à la base** :
   - Éditer `app/config/config.php`
   - Adapter `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` si besoin.

## Lancement

1. Configurer votre serveur web pour que le **document root** pointe sur le dossier `public/` du projet.
2. Accéder à l’application via votre navigateur (par exemple `http://localhost/Pathehp/public`).

Si votre serveur pointe déjà sur la racine du projet, la redirection depuis `index.php` vers `public/index.php` prendra le relais.

## Fonctionnalités principales

- Authentification (inscription, connexion, déconnexion, option *se souvenir de moi*).
- Gestion de compte utilisateur (modification, suppression).
- Listing des films et des séances.
- Réservation d’une ou plusieurs places (contrôle de disponibilité).
- Liste des réservations de l’utilisateur.
- Rôles `user` / `admin` :
  - L’admin peut gérer les films, les séances et supprimer des comptes utilisateurs.

## Sécurité

- Accès DB via PDO + requêtes préparées.
- Échappement systématique des données affichées pour limiter les XSS.
- Mots de passe stockés avec `password_hash` / `password_verify`.
- Expiration de session après inactivité (`SESSION_TIMEOUT` dans `config.php`).
