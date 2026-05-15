# Spec — Auth (US1)

**Feature :** Inscription / Connexion / Déconnexion
**Branch :** `feature/auth`
**Ticket Jira :** IP-1, IP-2, IP-3
**Agent utilisé :** Claude Code
**Date :** Jour 1 — 11/05/2026
......
---

## Contexte

Premier commit après AGENTS.md. L'authentification est la base de tout le projet — toutes les routes sont protégées derrière le middleware `auth`. On utilise Laravel Breeze (Blade) pour aller vite sans package superflu.

---

## Ce que je veux construire

- Page `/register` : formulaire avec name, email, password, password_confirmation
- Page `/login` : formulaire avec email, password + "Se souvenir de moi"
- Bouton logout dans la navbar (POST /logout)
- Redirection vers `/dashboard` après login/register
- Redirection vers `/login` si accès non authentifié

---

## Ce que je NE veux PAS

- Pas de Jetstream — trop lourd, on n'a pas besoin de teams ou d'API tokens
- Pas de vérification d'email (email_verified_at inutile ici)
- Pas de 2FA
- Pas de reset password pour l'instant (hors scope)
- Pas de contrôleur monolithique — je veux les contrôleurs Breeze séparés tels quels
- Pas de `validate()` inline dans le contrôleur — Form Request uniquement

---

## Stack attendue

```
php artisan breeze:install blade
```

Fichiers générés attendus :
- `app/Http/Controllers/Auth/RegisteredUserController.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- `resources/views/auth/register.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/layouts/app.blade.php`
- Migration `create_users_table` (déjà présente dans Laravel)

---

## Prompt donné à l'agent (mode Plan)

```
Je veux installer l'authentification avec Laravel Breeze (blade uniquement).
Donne-moi le plan exact : quelles commandes exécuter, quels fichiers seront créés,
et ce que je dois vérifier après l'installation.
Je NE veux PAS de vérification email, pas de Jetstream, pas de reset password.
```

---

## Plan validé par l'agent

1. `composer require laravel/breeze --dev`
2. `php artisan breeze:install blade`
3. `npm install && npm run dev`
4. `php artisan migrate`
5. Vérifier que `/register` et `/login` fonctionnent
6. Vérifier que le middleware `auth` redirige bien vers `/login`

---

## Ce que l'agent a généré

- Toute la structure Breeze correctement installée
- Les vues register/login avec les messages d'erreur Blade
- La navbar avec le lien logout
- Les routes dans `routes/auth.php`

## Ce que j'ai modifié manuellement

- Ajout d'un lien "Retour à l'accueil" sur la page login (absent de Breeze par défaut)
- Modification du layout `app.blade.php` pour intégrer la navbar avec les liens Domaines et Dashboard
- Suppression du lien "Profile" de la navbar (hors scope du projet)

---

## Critères de validation

- [x] `/register` crée un compte et redirige vers `/dashboard`
- [x] `/login` connecte et redirige vers `/dashboard`
- [x] Logout détruit la session et redirige vers `/login`
- [x] Une route protégée sans session redirige vers `/login`
- [x] Messages d'erreur affichés sous chaque champ invalide
