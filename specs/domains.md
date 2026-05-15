# Spec — Domains CRUD (US2, US3, US4)

**Feature :** Gestion des domaines techniques
**Branch :** `feature/domains-crud`
**Ticket Jira :** IP-4, IP-5, IP-6, IP-7
**Agent utilisé :** Claude Code
**Date :** Jour 2 — 12/05/2026

---

## Contexte

Un domaine est un regroupement de concepts (ex: "Laravel ORM", "PHP OOP", "MySQL"). L'utilisateur crée ses propres domaines avec un nom et une couleur de badge. Chaque domaine appartient à un seul utilisateur — les données sont isolées par `user_id`.

---

## Ce que je veux construire

### Modèle `Domain`
- Champs : `id`, `user_id` (FK), `name`, `color`, `created_at`, `updated_at`
- Relation : `belongsTo(User)` et `hasMany(Concept)`
- Accessors : aucun requis ici

### Controller `DomainController`
- `index()` — liste des domaines de l'utilisateur connecté avec `withCount('concepts')` et comptage des concepts maîtrisés
- `create()` — formulaire de création
- `store()` — validation + sauvegarde
- `edit()` — formulaire de modification pré-rempli
- `update()` — validation + mise à jour
- `destroy()` — suppression avec cascade sur les concepts

### Form Request `StoreDomainRequest` et `UpdateDomainRequest`
- `name` : requis, max 100, unique par user
- `color` : requis, format hex valide (regex `#[0-9A-Fa-f]{6}`)

### Policy `DomainPolicy`
- `update` et `delete` : `$domain->user_id === $user->id`

### Routes (resourceful)
```php
Route::resource('domains', DomainController::class)->middleware('auth');
```

### Vues Blade
- `domains/index.blade.php` — liste avec badge coloré, compteurs, boutons edit/delete
- `domains/create.blade.php` — formulaire création
- `domains/edit.blade.php` — formulaire modification pré-rempli

---

## Ce que je NE veux PAS

- Pas de `validate()` inline dans le controller — Form Request uniquement
- Pas de `if ($domain->user_id !== auth()->id()) abort(403)` manuel — Policy uniquement
- Pas de soft deletes sur Domain (uniquement sur Concept)
- Pas de champ `description` sur Domain — juste `name` et `color`
- Pas d'input color natif HTML — un select avec des couleurs prédéfinies suffit (6-8 couleurs)
- Pas de pagination pour l'instant — `->get()` simple
- Pas de AJAX — tout en Blade classique avec redirect

---

## Prompt donné à l'agent (mode Plan)

```
Je veux créer le CRUD complet pour un modèle Domain dans Laravel 11.
Un Domain appartient à un User et a plusieurs Concepts.
Champs : name (string), color (string hex), user_id (FK).

Génère-moi le plan complet :
- Migration
- Modèle avec relations
- Controller resourceful (index, create, store, edit, update, destroy)
- Form Requests StoreDomainRequest et UpdateDomainRequest
- Policy DomainPolicy (update, delete)
- Routes dans web.php
- Structure des vues Blade

Je NE veux PAS de validate() inline, pas de soft deletes, pas de champ description.
La validation 'unique' sur name doit être scoped à l'user courant, pas globale.
```

---

## Plan validé par l'agent

1. Migration `create_domains_table`
2. Modèle `Domain` avec `$fillable`, `belongsTo(User)`, `hasMany(Concept)`
3. `DomainController` avec les 5 méthodes resourceful
4. `StoreDomainRequest` + `UpdateDomainRequest` avec règle unique scoped
5. `DomainPolicy` enregistrée dans `AuthServiceProvider`
6. Routes resource dans `web.php` avec middleware auth
7. 3 vues Blade

---

## Ce que l'agent a généré

- Migration correcte avec `user_id` FK + `onDelete('cascade')`
- Modèle complet avec relations et `$fillable`
- Controller avec les méthodes resourceful et appel à la Policy via `$this->authorize()`
- Form Requests avec les règles de validation
- Les 3 vues Blade avec formulaires et listing

## Ce que j'ai modifié manuellement

- **Policy non enregistrée** : l'agent a créé le fichier Policy mais oublié de l'enregistrer dans `AuthServiceProvider`. Ajout manuel de `Domain::class => DomainPolicy::class` dans `$policies`.
- **N+1 sur index()** : l'agent utilisait `auth()->user()->domains` sans `withCount`. Remplacé par `Domain::where('user_id', auth()->id())->withCount(['concepts', 'concepts as mastered_count' => fn($q) => $q->where('status', 'mastered')])->get()`
- **Unique scoped** : la règle `'name' => 'unique:domains'` générée était globale. Remplacée par `Rule::unique('domains')->where('user_id', auth()->id())->ignore($domain->id)`
- **Select couleurs** : l'agent a généré un `<input type="color">` natif. Remplacé par un select avec 8 couleurs prédéfinies pour un meilleur rendu visuel.

---

## Critères de validation

- [x] Un utilisateur voit uniquement ses propres domaines
- [x] Création avec name + color fonctionne
- [x] Badge coloré affiché dans la liste
- [x] Compteur concepts total + maîtrisés affiché
- [x] Modification pré-remplie et fonctionnelle
- [x] Suppression en cascade (les concepts du domaine sont supprimés)
- [x] Un utilisateur ne peut pas modifier/supprimer le domaine d'un autre (403)
- [x] Zéro N+1 vérifié avec Laravel Debugbar
