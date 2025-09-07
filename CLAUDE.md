# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Architecture

Application Laravel avec une architecture MVC standard :
- **Frontend** : Blade templates avec Tailwind CSS v4 et Vite
- **Base de données** : SQLite (développement) avec Eloquent ORM
- **Authentication** : Laravel Auth intégré
- **Assets** : Vite pour le bundling (CSS/JS), Tailwind CSS pour les styles

### Modèles principaux
- `Article` : Articles avec catégories, secteurs et thèmes
- `Category` : Catégorisation des articles avec slug et statut
- `Magazine` : Magazines PDF avec couvertures et thumbnails
- `Webtv` : Contenu vidéo avec statuts (en_direct, programme, termine)
- `User` : Utilisateurs avec authentification

### Structure des vues
- `home.blade.php` : Page d'accueil
- `articles/` : Listing, catégories et articles individuels
- `magazines/` : Magazines et archives
- `dashboard/` : Interface administrateur
- `pages/` : Pages statiques (présentation, contact, etc.)

## Commandes de développement

### Installation et setup
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

### Développement
```bash
# Serveur de développement complet (serveur + queue + logs + vite)
composer dev

# Serveur Laravel uniquement
php artisan serve

# Assets (CSS/JS)
npm run dev    # Mode développement avec watch
npm run build  # Build de production
```

### Tests
```bash
composer test           # Lance les tests avec config
php artisan test        # Tests PHPUnit directs
```

### Code quality
```bash
vendor/bin/pint         # Laravel Pint (code formatting)
```

## Configuration importante

### Frontend
- Vite configuré pour `resources/css/app.css` et `resources/js/app.js`
- Tailwind CSS v4 avec plugin Vite `@tailwindcss/vite`
- Assets servis via `laravel-vite-plugin`

### Routes principales
- `/` : Page d'accueil avec actualités du jour et figures de l'économie
- `/articles` : Liste des articles avec pagination
- `/articles/category/{slug}` : Articles par catégorie avec filtrage par secteur/thème
- `/magazines` : Liste des magazines
- `/webtv` : Contenu WebTV avec catégorisation
- `/dashboard` : Interface admin (authentifiée)

### Fonctionnalités métier
- Articles avec secteurs (agriculture, technologie, industrie, services, energie)
- Catégories configurables via variables d'environnement (DAILY_NEWS_CATEGORY_SLUG, etc.)
- WebTV avec statuts temps réel et programmation
- Magazines avec PDF et système de téléchargement
- Système d'article à la une (featured) par catégorie

### Base de données
- Migrations dans `database/migrations/`
- Utilise SQLite par défaut (`:memory:` pour tests)
- Modèles avec relations Eloquent (belongsTo, withCount, etc.)