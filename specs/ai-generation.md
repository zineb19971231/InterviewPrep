# Spec — AI Generation (US11, US12, US13)

**Feature :** Génération de questions d'entretien via Groq API
**Branch :** `feature/ai-generation`
**Ticket Jira :** IP-14, IP-15, IP-16, IP-17, IP-18
**Agent utilisé :** Claude Code
**Date :** Jour 4 — 14/05/2026

---

## Contexte

Depuis la page détail d'un concept, l'utilisateur peut générer 5 questions d'entretien techniques réalistes. Les questions sont générées par l'API Groq (modèle LLaMA 3), sauvegardées en base avant affichage, et consultables dans un historique. L'appel se fait via `Http::` facade Laravel — zéro package externe.

---

## Ce que je veux construire

### Modèle `GeneratedQuestion`
- Champs : `id`, `concept_id` (FK), `questions` (JSON — tableau de 5 strings), `created_at`, `updated_at`
- Relation : `belongsTo(Concept)`
- Cast : `'questions' => 'array'` dans `$casts`

### Controller `GeneratedQuestionController`
- `store(Concept $concept)` — appel Groq API, parse réponse, sauvegarde en base, redirect show
- `destroy(GeneratedQuestion $generatedQuestion)` — suppression avec vérification ownership
- L'historique est affiché directement dans `ConceptController@show` via eager loading

### Service `GroqService` (optionnel mais propre)
- Méthode `generateQuestions(string $title, string $explanation): array`
- Encapsule l'appel `Http::` et le parsing
- Injectée dans `GeneratedQuestionController`

### Routes
```php
Route::middleware('auth')->group(function () {
    Route::post('concepts/{concept}/generate', [GeneratedQuestionController::class, 'store'])
         ->name('generated-questions.store');
    Route::delete('generated-questions/{generatedQuestion}', [GeneratedQuestionController::class, 'destroy'])
         ->name('generated-questions.destroy');
});
```

### Appel API Groq (Http:: facade)
```php
$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . config('services.groq.api_key'),
    'Content-Type'  => 'application/json',
])->post('https://api.groq.com/openai/v1/chat/completions', [
    'model'    => 'llama3-8b-8192',
    'messages' => [
        [
            'role'    => 'user',
            'content' => $this->buildPrompt($concept),
        ]
    ],
    'max_tokens'  => 800,
    'temperature' => 0.7,
]);
```

### Prompt envoyé à Groq
```
Tu es un recruteur technique senior spécialisé en développement backend.
Génère exactement 5 questions d'entretien techniques pour le concept suivant :

Concept : {titre}
Explication : {explication}

Règles :
- Les questions doivent être précises, techniques, et représentatives d'un vrai entretien
- Varie les types : compréhension, cas pratique, pièges courants, best practices
- Réponds UNIQUEMENT avec un tableau JSON de 5 strings, sans texte autour
- Format attendu : ["Question 1", "Question 2", "Question 3", "Question 4", "Question 5"]
```

### Configuration `.env`
```
GROQ_API_KEY=gsk_xxxxxxxxxxxxxxxxxxxx
```

### Configuration `config/services.php`
```php
'groq' => [
    'api_key' => env('GROQ_API_KEY'),
    'url'     => 'https://api.groq.com/openai/v1/chat/completions',
    'model'   => env('GROQ_MODEL', 'llama3-8b-8192'),
],
```

### Gestion d'erreur
```php
try {
    $response = Http::throw()->withHeaders([...])->post(...);
    $questions = json_decode($response->json('choices.0.message.content'), true);

    if (!is_array($questions) || count($questions) !== 5) {
        throw new \Exception('Réponse AI malformée');
    }
} catch (\Illuminate\Http\Client\RequestException $e) {
    Log::error('Groq API error: ' . $e->getMessage());
    return back()->with('error', 'Le service IA est indisponible. Réessaie dans quelques instants.');
} catch (\Exception $e) {
    Log::error('Groq parse error: ' . $e->getMessage());
    return back()->with('error', 'La réponse de l\'IA était invalide. Réessaie.');
}
```

---

## Ce que je NE veux PAS

- Pas de package `openai-php/client` ou autre SDK — `Http::` facade uniquement
- Pas de clé API en dur dans le code — `config('services.groq.api_key')` uniquement
- Pas de page blanche si l'API échoue — message flash d'erreur propre
- Pas d'affichage des questions avant sauvegarde en base
- Pas de streaming de la réponse — appel synchrone simple
- Pas de queue/job pour l'instant — traitement synchrone dans le controller
- Pas de retry automatique — un seul appel, erreur propre si ça échoue
- Pas de format markdown dans les questions — strings propres uniquement

---

## Prompt donné à l'agent (mode Plan)

```
Je veux intégrer l'API Groq dans mon projet Laravel 11 pour générer des questions d'entretien.
L'appel se fait via Http:: facade — ZÉRO package externe.

Ce que je veux :
- Un GeneratedQuestionController avec store() et destroy()
- Un GroqService qui encapsule l'appel Http::
- La clé API dans .env → config/services.php → config('services.groq.api_key')
- Gestion d'erreur avec try/catch + Log::error() + message flash (pas de page blanche)
- Questions sauvegardées en base (champ JSON) avant affichage
- Modèle GeneratedQuestion avec cast 'questions' => 'array'

Ce que je NE veux PAS :
- Aucun package SDK openai ou groq
- Pas de clé API en dur
- Pas d'affichage avant sauvegarde
- Pas de queue — synchrone uniquement

Donne-moi le plan complet avant de générer le code.
```

---

## Plan validé par l'agent

1. Migration `create_generated_questions_table` avec `concept_id` FK et `questions` JSON
2. Modèle `GeneratedQuestion` avec cast + relation
3. `GroqService` avec méthode `generateQuestions(Concept $concept): array`
4. `GeneratedQuestionController` avec `store()` et `destroy()`
5. Ajout dans `config/services.php`
6. Routes dans `web.php`
7. Mise à jour de la vue `concepts/show.blade.php` pour l'historique

---

## Ce que l'agent a généré

- Migration + modèle corrects avec cast JSON
- `GroqService` avec l'appel Http:: et le parsing de la réponse
- Controller avec les deux méthodes
- Routes dans `web.php`
- Section historique dans la vue `show.blade.php`

## Ce que j'ai modifié manuellement

- **Le prompt Groq** : l'agent avait généré un prompt trop vague ("Génère des questions sur {titre}"). Réécrit manuellement pour spécifier le format JSON attendu, le type de questions, et le nombre exact. Sans cette précision, l'API retournait du texte libre non parseable.
- **Parsing de la réponse** : l'agent faisait `json_decode($response->body())` directement sur le body entier au lieu de `$response->json('choices.0.message.content')`. Corrigé.
- **Validation de la réponse** : aucune vérification que le tableau retourné contient bien 5 éléments. Ajout du `if (!is_array($questions) || count($questions) !== 5)` avec throw.
- **Vérification ownership dans `destroy()`** : l'agent ne vérifiait pas que la génération appartient à un concept de l'utilisateur connecté. Ajout de `abort_if($generatedQuestion->concept->domain->user_id !== auth()->id(), 403)`
- **Log::error() manquant** : l'agent avait un try/catch mais sans logging. Ajout de `Log::error()` dans les deux catch.
- **Message d'erreur** : l'agent retournait `abort(500)` en cas d'erreur. Remplacé par `return back()->with('error', '...')` pour une UX propre.

---

## Critères de validation

- [x] Bouton "Générer des questions" visible sur la page détail du concept
- [x] 5 questions générées et sauvegardées en base avant affichage
- [x] Questions affichées sous forme de liste numérotée
- [x] Historique des générations passées visible (date + 5 questions par lot)
- [x] Suppression d'une génération fonctionnelle
- [x] Message d'erreur propre si l'API Groq est indisponible
- [x] Clé API absente du code et du repo (vérifiée dans .gitignore)
- [x] Aucun N+1 sur le chargement des générations
