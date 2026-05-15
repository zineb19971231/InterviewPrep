<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConceptRequest;
use App\Http\Requests\UpdateConceptRequest;
use App\Models\Concept;
use App\Models\Domain;

class ConceptController extends Controller
{
    public function index(Domain $domain)
    {
        $this->authorize('view', $domain);

        $concepts = $domain->concepts()
            ->when(request('status'), fn ($q, $s) => $q->where('status', $s))
            ->with('generatedQuestions')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('concepts.index', compact('domain', 'concepts'));
    }

    public function create(Domain $domain)
    {
        $this->authorize('view', $domain);

        return view('concepts.create', compact('domain'));
    }

    public function store(StoreConceptRequest $request, Domain $domain)
    {
        $this->authorize('view', $domain);

        $domain->concepts()->create($request->validated());

        return redirect()->route('domains.concepts.index', $domain)
            ->with('success', 'Concept créé avec succès.');
    }

    public function show(Concept $concept)
    {
        $this->authorize('view', $concept);

        $concept->load('generatedQuestions');

        return view('concepts.show', compact('concept'));
    }

    public function edit(Concept $concept)
    {
        $this->authorize('update', $concept);

        return view('concepts.edit', compact('concept'));
    }

    public function update(UpdateConceptRequest $request, Concept $concept)
    {
        $this->authorize('update', $concept);

        $concept->update($request->validated());

        return redirect()->route('domains.concepts.index', $concept->domain)
            ->with('success', 'Concept mis à jour avec succès.');
    }

    public function destroy(Concept $concept)
    {
        $this->authorize('delete', $concept);

        $concept->delete();

        return redirect()->route('domains.concepts.index', $concept->domain)
            ->with('success', 'Concept supprimé avec succès.');
    }

    public function updateStatus(Concept $concept)
    {
        $this->authorize('updateStatus', $concept);

        $validated = request()->validate([
            'status' => ['required', 'in:to_review,in_progress,mastered'],
        ]);

        $concept->update($validated);

        return redirect()->route('domains.concepts.index', $concept->domain)
            ->with('success', 'Statut mis à jour.');
    }
}
