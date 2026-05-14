<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\GeneratedQuestion;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GeneratedQuestionController extends Controller
{
    public function __construct(
        protected GroqService $groqService
    ) {}

    public function index()
    {
        $generations = GeneratedQuestion::whereHas('concept.domain', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->with('concept.domain')
            ->latest()
            ->paginate(10);

        return view('generated-questions.index', compact('generations'));
    }

    public function store(Concept $concept)
    {
        $this->authorize('view', $concept);

        try {
            $questions = $this->groqService->generateQuestions($concept);

            $concept->generatedQuestions()->create([
                'questions' => $questions,
            ]);

            return redirect()->route('concepts.show', $concept)
                ->with('success', '5 questions générées avec succès.');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Groq API error: ' . $e->getMessage());
            return back()->with('error', 'Le service IA est indisponible. Réessaie dans quelques instants.');
        } catch (\Exception $e) {
            Log::error('Groq parse error: ' . $e->getMessage());
            return back()->with('error', 'La réponse de l\'IA était invalide. Réessaie.');
        }
    }

    public function destroy(GeneratedQuestion $generatedQuestion)
    {
        abort_if(
            $generatedQuestion->concept->domain->user_id !== auth()->id(),
            403
        );

        $generatedQuestion->delete();

        return back()->with('success', 'Génération supprimée.');
    }
}
