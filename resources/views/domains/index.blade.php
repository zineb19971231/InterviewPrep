<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="page-title">Domaines</h1>
                <p class="page-subtitle">Organisez vos concepts par technologie</p>
            </div>
            <a href="{{ route('domains.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau domaine
            </a>
        </div>

        @if(session('success'))
            <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($domains->isEmpty())
            <div class="card p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-primary-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <h2 class="section-title mb-2">Aucun domaine</h2>
                <p class="text-surface-500 mb-6 max-w-md mx-auto">Commencez par créer votre premier domaine technique.</p>
                <a href="{{ route('domains.create') }}" class="btn-primary inline-flex">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Créer un domaine
                </a>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                @foreach($domains as $domain)
                    <div class="card card-hover group">
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-4 h-4 rounded-lg flex-shrink-0" style="background-color: {{ $domain->color }}"></div>
                                    <h3 class="text-base font-semibold text-surface-900 group-hover:text-primary-700 transition-colors">
                                        {{ $domain->name }}
                                    </h3>
                                </div>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('domains.edit', $domain) }}" class="p-1.5 rounded-lg text-surface-400 hover:text-surface-600 hover:bg-surface-100 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('domains.destroy', $domain) }}" onsubmit="return confirm('Supprimer ce domaine et tous ses concepts ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-surface-400 hover:text-danger-600 hover:bg-danger-50 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-surface-100 text-surface-600">
                                        {{ $domain->concepts_count }} concept{{ $domain->concepts_count !== 1 ? 's' : '' }}
                                    </span>
                                </div>
                                <a href="{{ route('domains.concepts.index', $domain) }}" class="inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-500 transition-colors">
                                    Voir
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        @if($domain->concepts_count > 0)
                            <div class="px-5 py-3 bg-surface-50 border-t border-surface-200">
                                @php
                                    $percentage = $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0;
                                @endphp
                                <div class="flex items-center justify-between text-xs mb-1.5">
                                    <span class="text-surface-500">Maîtrise</span>
                                    <span class="text-success-600 font-medium">{{ $percentage }}%</span>
                                </div>
                                <div class="h-1.5 bg-surface-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-success-500 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>