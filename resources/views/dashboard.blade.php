<x-app-layout>
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Bon retour, {{ Auth::user()->name }} — voici ta progression</p>
            </div>
            <a href="{{ route('domains.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau domaine
            </a>
        </div>

        @if ($totalConcepts === 0)
            <div class="card p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-primary-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h2 class="section-title mb-2">Prêt à préparer vos entretiens ?</h2>
                <p class="text-surface-500 mb-6 max-w-md mx-auto">Commencez par créer votre premier domaine technique pour organiser vos concepts.</p>
                <a href="{{ route('domains.create') }}" class="btn-primary inline-flex">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Créer mon premier domaine
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <div class="card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-surface-400 uppercase tracking-wider">Domaines</span>
                    </div>
                    <p class="text-3xl font-bold text-surface-900">{{ $totalDomains }}</p>
                </div>

                <div class="card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-surface-400 uppercase tracking-wider">Concepts</span>
                    </div>
                    <p class="text-3xl font-bold text-surface-900">{{ $totalConcepts }}</p>
                </div>

                <div class="card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-success-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-surface-400 uppercase tracking-wider">Maîtrisés</span>
                    </div>
                    <p class="text-3xl font-bold text-surface-900">{{ $mastered }}</p>
                </div>

                <div class="card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-warning-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-surface-400 uppercase tracking-wider">Questions AI</span>
                    </div>
                    <p class="text-3xl font-bold text-surface-900">{{ $generatedCount }}</p>
                </div>
            </div>

            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b border-surface-200">
                    <h2 class="section-title">Progression globale</h2>
                    <p class="mt-1 text-sm text-surface-500">{{ $masteryPercentage }}% des concepts maîtrisés</p>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-surface-700 font-medium">Maîtrisé</span>
                            <span class="text-success-600 font-medium">{{ $mastered }}</span>
                        </div>
                        <div class="h-2.5 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-success-500 rounded-full transition-all duration-500" style="width: {{ $totalConcepts > 0 ? ($mastered / $totalConcepts) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-surface-700 font-medium">En cours</span>
                            <span class="text-warning-600 font-medium">{{ $inProgress }}</span>
                        </div>
                        <div class="h-2.5 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-warning-500 rounded-full transition-all duration-500" style="width: {{ $totalConcepts > 0 ? ($inProgress / $totalConcepts) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-surface-700 font-medium">À revoir</span>
                            <span class="text-danger-600 font-medium">{{ $toReview }}</span>
                        </div>
                        <div class="h-2.5 bg-surface-100 rounded-full overflow-hidden">
                            <div class="h-full bg-danger-500 rounded-full transition-all duration-500" style="width: {{ $totalConcepts > 0 ? ($toReview / $totalConcepts) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <div class="card overflow-hidden">
                    <div class="px-6 py-4 border-b border-surface-200 flex items-center justify-between">
                        <h2 class="section-title">Domaines récents</h2>
                        <a href="{{ route('domains.index') }}" class="link text-sm">Voir tout</a>
                    </div>
                    <div class="divide-y divide-surface-100">
                        @forelse ($recentDomains as $domain)
                            <a href="{{ route('domains.concepts.index', $domain) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-surface-50 transition-colors">
                                <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $domain->color }}"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-surface-800 truncate">{{ $domain->name }}</p>
                                    <p class="text-xs text-surface-500">{{ $domain->concepts_count }} concept{{ $domain->concepts_count > 1 ? 's' : '' }}</p>
                                </div>
                                <svg class="w-5 h-5 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <p class="text-sm text-surface-500">Aucun domaine pour le moment</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="card overflow-hidden">
                    <div class="px-6 py-4 border-b border-surface-200 flex items-center justify-between">
                        <h2 class="section-title">Derniers concepts</h2>
                        <a href="{{ route('domains.index') }}" class="link text-sm">Voir tout</a>
                    </div>
                    <div class="divide-y divide-surface-100">
                        @forelse ($recentConcepts as $concept)
                            <a href="{{ route('concepts.show', $concept) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-surface-50 transition-colors">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-surface-800 truncate">{{ $concept->title }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-surface-500">{{ $concept->domain->name }}</span>
                                        <span class="w-1 h-1 rounded-full bg-surface-300"></span>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium
                                            @if($concept->status === 'mastered') bg-success-50 text-success-700
                                            @elseif($concept->status === 'in_progress') bg-warning-50 text-warning-700
                                            @else bg-danger-50 text-danger-700
                                            @endif">
                                            {{ $concept->status_label }}
                                        </span>
                                    </div>
                                </div>
                                @if($concept->generatedQuestions->count() > 0)
                                    <span class="flex items-center gap-1 text-xs text-primary-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $concept->generatedQuestions->count() }}
                                    </span>
                                @endif
                                <svg class="w-5 h-5 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <p class="text-sm text-surface-500">Aucun concept pour le moment</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>