<x-app-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="page-title">Historique des questions AI</h1>
                <p class="page-subtitle">Toutes les générations de questions d'entretien</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($generations->isEmpty())
            <div class="card p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-primary-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="section-title mb-2">Aucune génération</h2>
                <p class="text-surface-500 mb-6 max-w-md mx-auto">Les questions générées depuis la page détail d'un concept apparaîtront ici.</p>
                <a href="{{ route('domains.index') }}" class="btn-primary inline-flex">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Voir mes domaines
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($generations as $generation)
                    <div class="card overflow-hidden">
                        <div class="px-6 py-4 border-b border-surface-200 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: {{ $generation->concept->domain->color }}"></div>
                                <div>
                                    <a href="{{ route('concepts.show', $generation->concept) }}" class="text-sm font-medium text-surface-800 hover:text-primary-600 transition-colors">
                                        {{ $generation->concept->title }}
                                    </a>
                                    <p class="text-xs text-surface-500 mt-0.5">
                                        {{ $generation->concept->domain->name }} — {{ $generation->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('generated-questions.destroy', $generation) }}" onsubmit="return confirm('Supprimer cette génération ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-surface-400 hover:text-danger-600 hover:bg-danger-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="p-6">
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

            <div class="mt-6">
                {{ $generations->links() }}
            </div>
        @endif
    </div>
</x-app-layout>