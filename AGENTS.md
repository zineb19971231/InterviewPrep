# AGENTS.md — InterviewPrep

> Ce fichier documente le workflow AI-Assisted utilisé tout au long du développement de ce projet.
> Il est commité dès le Jour 1 et mis à jour à chaque feature.

---

## Coding Agent utilisé

OpenCode — opencode.ai

Utilisé depuis PowerShell directement dans le dossier du projet Laravel.
L'agent était lancé en mode terminal pour générer les fichiers, proposer l'architecture et accélérer certaines tâches répétitives.
Chaque feature est construite en deux phases obligatoires :

1. **Mode Plan** — l'agent lit la spec (`specs/<feature>.md`) et propose une architecture : fichiers à créer, routes, méthodes, relations. Je valide ou corrige avant de continuer.
2. **Mode Build** — l'agent génère le code. Je relis, teste, et modifie ce qui ne correspond pas exactement à mes attentes.

---

## API AI intégrée dans l'application

**Groq API** — `console.groq.com`

- Modèle utilisé : `llama3-8b-8192`
- Appel via `Http::` facade Laravel natif — zéro package externe
- Clé dans `.env` sous `GROQ_API_KEY` — jamais dans le code, jamais commitée
- `.gitignore` vérifié : `.env` exclu

---

## Conventions de commits

Format obligatoire pour tous les commits :

```
<type>(<scope>): <description> [AI: Claude Code] ou [manual]
```

**Types utilisés :**
- `feat` — nouvelle fonctionnalité
- `fix` — correction de bug
- `refactor` — réécriture sans changement de comportement
- `chore` — config, migrations, seeders
- `docs` — AGENTS.md, specs/, README

**Exemples réels :**
```
chore(setup): init Laravel project + AGENTS.md [manual]
feat(auth): add register/login/logout with Breeze [AI: Claude Code]
feat(domains): CRUD domains with color badge [AI: Claude Code]
fix(domains): fix cascade delete missing on concepts [manual]
feat(concepts): CRUD concepts + quick status change [AI: Claude Code]
refactor(concepts): extract statusLabel() accessor + N+1 fix [manual]
feat(ai): integrate Groq API via Http:: facade [AI: Claude Code]
fix(ai): add error handling when Groq API times out [manual]
docs(specs): add specs for auth, domains, concepts, ai-generation [manual]
```

---

## Règles données à l'agent

Ces règles sont rappelées à chaque session :

```
Tu travailles sur un projet Laravel 13.
- Utilise toujours les Form Request classes pour la validation (jamais validate() inline dans le controller)
- Utilise les Policies Laravel pour l'autorisation (jamais de if manuel dans le controller)
- Charge les relations avec eager loading (with() ou load()) — jamais de lazy loading en boucle
- N'installe aucun package externe sauf si je te le demande explicitement
- L'appel à l'API Groq se fait uniquement via Http:: facade, jamais via Guzzle direct
- Ne mets jamais de clé API dans le code — utilise env() ou config()
- Génère les migrations avec les bons types : enum pour status et difficulty
- Respecte le nommage Laravel : snake_case pour les colonnes, PascalCase pour les classes
```

---

## Ce que l'agent fait bien

- Génération rapide des migrations, modèles et controllers complets
- Respect des conventions Laravel si les règles sont bien spécifiées
- Génération des routes resourceful et des Form Requests
- Suggestions pertinentes pour les relations Eloquent

## Ce que j'ai dû corriger manuellement

- Les Policies n'étaient pas enregistrées dans `AuthServiceProvider` → ajout manuel
- Le N+1 sur la liste des domaines (`withCount` manquant) → corrigé avec Debugbar
- Le prompt envoyé à Groq était trop générique → réécrit manuellement pour obtenir des questions techniques réalistes
- La gestion d'erreur sur l'appel Http:: était absente → ajout du try/catch + Log::error()
- Les accessors `statusLabel()` et `difficultyLabel()` générés sans `Attribute` cast Laravel 13 → refactorisé

---

## Structure des branches

```
main
├── feature/auth
├── feature/domains-crud
├── feature/concepts-crud
└── feature/ai-generation
```

Chaque branche correspond à un ticket Jira et une spec dans `specs/`.

---

## Fichiers specs/ associés

| Feature | Fichier spec | Branch |
|---------|-------------|--------|
| Auth | `specs/auth.md` | `feature/auth` |
| Domaines CRUD | `specs/domains.md` | `feature/domains-crud` |
| Concepts CRUD | `specs/concepts.md` | `feature/concepts-crud` |
| AI Generation | `specs/ai-generation.md` | `feature/ai-generation` |
| Dashboard Bonus | `specs/dashboard.md` | `main` |
