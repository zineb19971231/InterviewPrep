<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <a href="{{ route('domains.concepts.index', $concept->domain) }}" class="inline-flex items-center gap-2 text-sm text-surface-500 hover:text-surface-700 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        @if(session('success'))
            <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-danger-50 border border-danger-200 text-danger-700 px-4 py-3 rounded-xl text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="p-6 lg:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-surface-900">{{ $concept->title }}</h1>
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium text-white" style="background-color: {{ $concept->domain->color }}">
                                {{ $concept->domain->name }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
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
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
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
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('concepts.edit', $concept) }}" class="btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('concepts.destroy', $concept) }}" onsubmit="return confirm('Supprimer ce concept ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-danger-50 hover:bg-danger-100 text-danger-700 text-sm font-medium rounded-lg transition-all duration-200 border border-danger-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-surface-50 border border-surface-200 rounded-xl p-5 text-surface-700 text-sm leading-relaxed whitespace-pre-wrap">
                    {{ $concept->explanation }}
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="px-6 lg:px-8 py-5 border-b border-surface-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="section-title">Questions d'entretien</h2>
                    <p class="text-sm text-surface-500 mt-1">Générées par IA via Groq API</p>
                </div>
                <form method="POST" action="{{ route('generated-questions.store', $concept) }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Générer des questions
                    </button>
                </form>
            </div>

            <div class="p-6 lg:p-8">
                @if($concept->generatedQuestions->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-surface-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-surface-500 text-sm">Aucune question générée pour le moment.</p>
                        <p class="text-surface-400 text-xs mt-1">Cliquez sur le bouton ci-dessus pour générer 5 questions d'entretien.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($concept->generatedQuestions as $generation)
                            <div class="bg-white border border-surface-200 rounded-xl overflow-hidden">
                                <div class="px-5 py-3 border-b border-surface-100 flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        <span class="text-surface-500">Généré le</span>
                                        <span class="text-surface-700 font-medium">{{ $generation->created_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                    <form method="POST" action="{{ route('generated-questions.destroy', $generation) }}" onsubmit="return confirm('Supprimer cette génération ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-surface-400 hover:text-danger-600 hover:bg-danger-50 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="p-5">
                                    <ol class="space-y-3">
                                        @foreach($generation->questions as $index => $question)
                                            <li class="flex items-start gap-3">
                                                <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-primary-50 text-primary-600 text-xs font-medium flex items-center justify-center">
                                                    {{ $index + 1 }}
                                                </span>
                                                <span class="text-sm text-surface-700 leading-relaxed pt-0.5">{{ $question }}</span>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>