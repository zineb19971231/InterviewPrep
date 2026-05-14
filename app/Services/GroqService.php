<?php

namespace App\Services;

use App\Models\Concept;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    public function generateQuestions(Concept $concept): array
    {
        $response = Http::timeout(60)->withHeaders([
            'Authorization' => 'Bearer ' . config('services.groq.api_key'),
            'Content-Type' => 'application/json',
        ])->post(config('services.groq.url'), [
            'model' => config('services.groq.model'),
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $this->buildPrompt($concept),
                ],
            ],
            'max_tokens' => 800,
            'temperature' => 0.7,
        ])->throw();

        $questions = json_decode($response->json('choices.0.message.content'), true);

        if (!is_array($questions) || count($questions) !== 5) {
            throw new \Exception('Réponse AI malformée');
        }

        return $questions;
    }

    private function buildPrompt(Concept $concept): string
    {
        return "Tu es un recruteur technique senior spécialisé en développement backend.\n"
            . "Génère exactement 5 questions d'entretien techniques pour le concept suivant :\n\n"
            . "Concept : {$concept->title}\n"
            . "Explication : {$concept->explanation}\n\n"
            . "Règles :\n"
            . "- Les questions doivent être précises, techniques, et représentatives d'un vrai entretien\n"
            . "- Varie les types : compréhension, cas pratique, pièges courants, best practices\n"
            . "- Réponds UNIQUEMENT avec un tableau JSON de 5 strings, sans texte autour\n"
            . "- Format attendu : [\"Question 1\", \"Question 2\", \"Question 3\", \"Question 4\", \"Question 5\"]";
    }
}
