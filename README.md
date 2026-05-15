# InterviewPrep

Application Laravel pour préparer vos entretiens techniques. Organisez vos connaissances par domaines, suivez votre progression et générez des questions d'entraînement avec l'IA.
## Page d'acceuil
<img width="1732" height="907" alt="image" src="https://github.com/user-attachments/assets/12fb783c-218f-4881-99d9-6a8a70871093" />
## Dashboard
<img width="1885" height="917" alt="image" src="https://github.com/user-attachments/assets/6dc3c293-ee07-4da3-9a5d-a42fc355d8d8" />

## Fonctionnalités

- **Authentification** — Inscription, connexion (Laravel Breeze)
- **Domaines** — CRUD avec badge couleur, compteur de concepts, barre de progression
- **Concepts** — CRUD avec statut (À revoir / En cours / Maîtrisé), difficulté (Junior / Mid / Senior), soft deletes
- **Génération IA** — 5 questions techniques par concept via Groq API (LLaMA 3.3 70B)
- **Dashboard** — Statistiques, progression globale, listes récentes

## Stack

| Outil | Version |
|-------|---------|
| Laravel | 13 |
| PHP | 8.3 |
| Base de données | SQLite |
| CSS | Tailwind CSS 3 |
| Frontend | Alpine.js 3.4 + Blade |
| IA | Groq API (llama3-70b-8192) |
| Auth | Breeze (Blade) |
| API Auth | Sanctum |

## Installation

```bash
git clone https://github.com/votre-username/interview-prep.git
cd interview-prep
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Clé API Groq

```env
GROQ_API_KEY=votre_clé
GROQ_MODEL=llama3-70b-8192
```

Obtenez une clé sur [console.groq.com](https://console.groq.com).

## Tests

```bash
php artisan test
```

## Licence

MIT
