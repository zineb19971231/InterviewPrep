# Spec — Concepts CRUD (US5 → US10)

**Feature :** Gestion des concepts techniques
**Branch :** `feature/concepts-crud`
**Ticket Jira :** IP-8, IP-9, IP-10, IP-11, IP-12, IP-13
**Agent utilisé :** Claude Code
**Date :** Jour 3 — 13/05/2026

---

## Contexte

Un concept est une notion technique que l'utilisateur veut maîtriser (ex: "Eloquent N+1 Problem", "Liskov Substitution Principle"). Il appartient à un Domain, a un niveau de difficulté (junior/mid/senior) et un statut de maîtrise (to_review/in_progress/mastered). L'utilisateur peut changer le statut rapidement depuis la liste sans ouvrir le formulaire.

---

## Ce que je veux construire

### Modèle `Concept`
- Champs : `id`, `domain_id` (FK), `title`, `explanation` (text), `difficulty` (enum), `status` (enum), `deleted_at` (nullable pour soft deletes bonus), `created_at`, `updated_at`
- Relations : `belongsTo(Domain)`, `hasMany(GeneratedQuestion)`
- **Accessor `statusLabel()`** : retourne "À revoir" / "En cours" / "Maîtrisé"
- **Accessor `difficultyLabel()`** : retourne "Junior" / "Mid" / "Senior"

### Controller `ConceptController`
- `index(Domain $domain)` — liste des concepts du domaine avec filtre statut + difficulté (bonus)
- `create(Domain $domain)` — formulaire création
- `store(Domain $domain)` — validation + sauvegarde (status = 'to_review' par défaut)
- `show(Concept $concept)` — détail avec generatedQuestions
- `edit(Concept $concept)` — formulaire modification
- `update(Concept $concept)` — validation + mise à jour
- `destroy(Concept $concept)` — suppression (soft delete si bonus activé)
- **`updateStatus(Concept $concept)`** — route PATCH dédiée pour changement rapide de statut

### Form Requests
- `StoreConceptRequest` : title requis max 255, explanation requis, difficulty enum valide
- `UpdateConceptRequest` : mêmes règles + status enum valide

### Policy `ConceptPolicy`
- Toutes les actions vérifiées : `$concept->domain->user_id === $user->id`

### Routes
```php
Route::middleware('auth')->group(function () {
    Route::resource('domains.concepts', ConceptController::class)->shallow();
    Route::patch('concepts/{concept}/status', [ConceptController::class, 'updateStatus'])
         ->name('concepts.updateStatus');
});
```

### Vues Blade
- `concepts/index.blade.php` — liste avec badges niveau/statut, filtre, bouton changement statut rapide
- `concepts/create.blade.php` — formulaire création
- `concepts/edit.blade.php` — formulaire modification
- `concepts/show.blade.php` — détail complet + section questions générées

---

## Ce que je NE veux PAS

- Pas de `validate()` inline — Form Request uniquement
- Pas de `if auth()->id() !== ...` manuel — Policy uniquement
- Pas d'AJAX pour le changement de statut rapide — un simple formulaire POST avec `@method('PATCH')` dans la liste suffit
- Pas de champ `tags` ou `resources` — hors scope
- Pas de tri personnalisé — ordre par `created_at DESC` par défaut
- Les accessors doivent utiliser la syntaxe Laravel 11 (`Attribute::get(...)`) pas l'ancienne syntaxe `getStatusLabelAttribute()`
- Pas de migration séparée pour les enum — définir les valeurs directement dans la migration avec `->enum('status', ['to_review', 'in_progress', 'mastered'])`

---

## Prompt donné à l'agent (mode Plan)

```
Je veux créer le CRUD complet pour un modèle Concept dans Laravel 11.
Un Concept appartient à un Domain (nested resource) et a plusieurs GeneratedQuestion.

Champs : title (string), explanation (text), difficulty (enum: junior/mid/senior),
status (enum: to_review/in_progress/mastered — défaut: to_review), domain_id (FK).

Je veux aussi :
- Une route PATCH séparée pour mettre à jour uniquement le status (changement rapide depuis la liste)
- Deux accessors statusLabel() et difficultyLabel() en syntaxe Laravel 11 (Attribute::get)
- Une ConceptPolicy pour toutes les actions (vérifier domain->user_id)
- Des Form Requests séparés pour store et update

Je NE veux PAS :
- validate() inline
- if auth()->id() !== ... manuel
- AJAX pour le changement de statut
- L'ancienne syntaxe getStatusLabelAttribute()

Donne-moi le plan complet avant de générer le code.
```

---

## Plan validé par l'agent

1. Migration `create_concepts_table` avec enums et FK domain_id
2. Modèle `Concept` avec relations, fillable, accessors Laravel 11
3. `ConceptController` avec 7 méthodes + `updateStatus()`
4. `StoreConceptRequest` + `UpdateConceptRequest`
5. `ConceptPolicy` avec toutes les gates
6. Routes nested shallow + route PATCH status
7. 4 vues Blade

---

## Ce que l'agent a généré

- Migration correcte avec les deux enums et cascade delete
- Modèle avec les accessors en syntaxe Laravel 11 correcte
- Controller avec toutes les méthodes, `authorize()` via Policy
- Les deux Form Requests avec les règles enum via `Rule::in([...])`
- Les 4 vues Blade

## Ce que j'ai modifié manuellement

- **Filtre dans `index()`** : l'agent a généré `->where('status', $request->status)` sans le `when()` conditionnel. Si `$request->status` est null, ça retournait zéro résultats. Corrigé avec `->when($request->status, fn($q, $s) => $q->where('status', $s))`
- **Eager loading dans `show()`** : l'agent a oublié de charger `generatedQuestions`. Ajouté `$concept->load('generatedQuestions')`
- **Policy `updateStatus`** : l'agent n'avait pas de gate dédiée pour `updateStatus` dans la Policy. Ajouté la méthode `updateStatus` dans `ConceptPolicy` et l'appel `$this->authorize('updateStatus', $concept)` dans le controller
- **Vue `index`** : le formulaire de changement de statut rapide généré utilisait un lien GET au lieu d'un form POST avec `@method('PATCH')`. Corrigé pour respecter REST
- **Accessors** : `difficultyLabel()` retournait `'mid'` au lieu de `'Mid-level'` (minuscule). Mis à jour les valeurs d'affichage

---

## Critères de validation

- [x] Liste des concepts filtrée par domaine et par user
- [x] Filtre par statut fonctionnel (?status=to_review, ?status=in_progress, ?status=mastered)
- [x] Création avec statut par défaut "to_review"
- [x] Badges "Junior/Mid/Senior" et "À revoir/En cours/Maîtrisé" affichés via accessors
- [x] Changement de statut rapide depuis la liste (sans ouvrir le formulaire)
- [x] Page détail avec explication complète et section questions générées
- [x] Modification pré-remplie et fonctionnelle
- [x] Suppression avec confirmation
- [x] Un utilisateur ne peut pas accéder aux concepts d'un autre utilisateur (403)
- [x] Zéro N+1 vérifié avec Laravel Debugbar
