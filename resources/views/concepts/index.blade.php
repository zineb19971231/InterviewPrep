<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-4 h-4 rounded-lg flex-shrink-0" style="background-color: {{ $domain->color }}"></div>
                    <h1 class="page-title">{{ $domain->name }}</h1>
                </div>
                <p class="page-subtitle ml-7">Liste des concepts</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('domains.index') }}" class="btn-secondary text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Domaines
                </a>
                <a href="{{ route('domains.concepts.create', $domain) }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau concept
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('domains.concepts.index', $domain) }}"
               class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200
               {{ !request('status') ? 'bg-primary-50 text-primary-700 border border-primary-200' : 'text-surface-600 hover:text-surface-800 bg-white border border-surface-200 hover:border-surface-300' }}">
                Tous
            </a>
            <a href="{{ route('domains.concepts.index', ['domain' => $domain, 'status' => 'to_review']) }}"
               class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200
               {{ request('status') === 'to_review' ? 'bg-danger-50 text-danger-700 border border-danger-200' : 'text-surface-600 hover:text-surface-800 bg-white border border-surface-200 hover:border-surface-300' }}">
                À revoir
            </a>
            <a href="{{ route('domains.concepts.index', ['domain' => $domain, 'status' => 'in_progress']) }}"
               class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200
               {{ request('status') === 'in_progress' ? 'bg-warning-50 text-warning-700 border border-warning-200' : 'text-surface-600 hover:text-surface-800 bg-white border border-surface-200 hover:border-surface-300' }}">
                En cours
            </a>
            <a href="{{ route('domains.concepts.index', ['domain' => $domain, 'status' => 'mastered']) }}"
               class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200
               {{ request('status') === 'mastered' ? 'bg-success-50 text-success-700 border border-success-200' : 'text-surface-600 hover:text-surface-800 bg-white border border-surface-200 hover:border-surface-300' }}">
                Maîtrisé
            </a>
        </div>

        @if($concepts->isEmpty())
            <div class="card p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-primary-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h2 class="section-title mb-2">Aucun concept</h2>
                <p class="text-surface-500 mb-6 max-w-md mx-auto">Ajoutez votre premier concept à ce domaine.</p>
                <a href="{{ route('domains.concepts.create', $domain) }}" class="btn-primary inline-flex">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter un concept
                </a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($concepts as $concept)
                    <div class="card card-hover group">
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <a href="{{ route('concepts.show', $concept) }}" class="text-base font-semibold text-surface-900 group-hover:text-primary-700 transition-colors truncate">
                                            {{ $concept->title }}
                                        </a>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium
                                            @if($concept->difficulty === 'junior') bg-success-50 text-success-700 border border-success-200
                                            @elseif($concept->difficulty === 'mid') bg-warning-50 text-warning-700 border border-warning-200
                                            @else bg-danger-50 text-danger-700 border border-danger-200
                                            @endif">
                                            <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                                @if($concept->difficulty === 'junior') bg-success-500
                                                @elseif($concept->difficulty === 'mid') bg-warning-500
                                                @else bg-danger-500
                                                @endif">
                                            </span>
                                            {{ $concept->difficulty_label }}
                                        </span>

                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium
                                            @if($concept->status === 'mastered') bg-success-50 text-success-700 border border-success-200
                                            @elseif($concept->status === 'in_progress') bg-warning-50 text-warning-700 border border-warning-200
                                            @else bg-danger-50 text-danger-700 border border-danger-200
                                            @endif">
                                            @if($concept->status === 'mastered')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @elseif($concept->status === 'in_progress')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                </svg>
                                            @endif
                                            {{ $concept->status_label }}
                                        </span>

                                        @if($concept->generatedQuestions->count() > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-primary-50 text-primary-700 border border-primary-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $concept->generatedQuestions->count() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('concepts.updateStatus', $concept) }}" class="relative">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                                class="appearance-none bg-white border border-surface-300 text-surface-600 text-xs rounded-lg px-3 py-2 pr-8 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all cursor-pointer">
                                            <option value="to_review" {{ $concept->status === 'to_review' ? 'selected' : '' }}>À revoir</option>
                                            <option value="in_progress" {{ $concept->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                            <option value="mastered" {{ $concept->status === 'mastered' ? 'selected' : '' }}>Maîtrisé</option>
                                        </select>
                                        <svg class="w-3 h-3 text-surface-400 absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </form>

                                    <a href="{{ route('concepts.edit', $concept) }}" class="p-2 rounded-lg text-surface-400 hover:text-surface-600 hover:bg-surface-100 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('concepts.destroy', $concept) }}" onsubmit="return confirm('Supprimer ce concept ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-surface-400 hover:text-danger-600 hover:bg-danger-50 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>