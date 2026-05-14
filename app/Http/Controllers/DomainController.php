<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;


class DomainController extends Controller
{
    public function index()
    {
        $domains = Domain::where('user_id', auth()->id())
            ->withCount('concepts')
            ->withCount(['concepts as mastered_count' => fn ($q) => $q->where('status', 'mastered')])
            ->orderBy('name')
            ->get();

        return view('domains.index', compact('domains'));
    }

    public function create()
    {
        return view('domains.create');
    }

    public function store(StoreDomainRequest $request)
    {
        Domain::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return redirect()->route('domains.index')
            ->with('success', 'Domaine créé avec succès.');
    }

    public function edit(Domain $domain)
    {
        $this->authorize('update', $domain);

        return view('domains.edit', compact('domain'));
    }

    public function update(UpdateDomainRequest $request, Domain $domain)
    {
        $this->authorize('update', $domain);

        $domain->update($request->validated());

        return redirect()->route('domains.index')
            ->with('success', 'Domaine mis à jour avec succès.');
    }

    public function destroy(Domain $domain)
    {
        $this->authorize('delete', $domain);

        $domain->delete();

        return redirect()->route('domains.index')
            ->with('success', 'Domaine supprimé avec succès.');
    }
}
