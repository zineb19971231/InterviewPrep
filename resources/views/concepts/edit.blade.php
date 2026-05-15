<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('domains.concepts.index', $concept->domain) }}" class="inline-flex items-center gap-2 text-sm text-surface-500 hover:text-surface-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux concepts
            </a>
        </div>

        <div class="card">
            <div class="px-6 py-5 border-b border-surface-200">
                <h1 class="text-xl font-bold text-surface-900">Modifier le concept</h1>
                <p class="mt-1 text-sm text-surface-500">Mettez à jour les informations du concept</p>
            </div>

            <form method="POST" action="{{ route('concepts.update', $concept) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-surface-700 mb-2">Titre du concept</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $concept->title) }}" required
                           class="input">
                    @error('title')
                        <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="explanation" class="block text-sm font-medium text-surface-700 mb-2">Explication</label>
                    <textarea id="explanation" name="explanation" rows="6" required
                              class="input resize-y">{{ old('explanation', $concept->explanation) }}</textarea>
                    @error('explanation')
                        <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-2">Difficulté</label>
                        <div class="grid grid-cols-3 gap-2">
                            @php $difficultyOptions = [
                                'junior' => ['Junior', 'border-success-500 bg-success-50 text-success-700'],
                                'mid' => ['Mid', 'border-warning-500 bg-warning-50 text-warning-700'],
                                'senior' => ['Senior', 'border-danger-500 bg-danger-50 text-danger-700'],
                            ] @endphp
                            @foreach($difficultyOptions as $value => [$label, $checkedClasses])
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="difficulty" value="{{ $value }}" {{ old('difficulty', $concept->difficulty) === $value ? 'checked' : '' }} class="sr-only peer">
                                    <div class="px-3 py-2.5 rounded-lg text-center text-xs font-medium transition-all duration-200 border border-surface-200 bg-white text-surface-600 peer-checked:{{ $checkedClasses }} group-hover:border-surface-300">
                                        {{ $label }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('difficulty')
                            <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-2">Statut</label>
                        <div class="relative">
                            <select name="status" required class="input appearance-none">
                                <option value="to_review" {{ old('status', $concept->status) === 'to_review' ? 'selected' : '' }}>À revoir</option>
                                <option value="in_progress" {{ old('status', $concept->status) === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="mastered" {{ old('status', $concept->status) === 'mastered' ? 'selected' : '' }}>Maîtrisé</option>
                            </select>
                            <svg class="w-4 h-4 text-surface-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        @error('status')
                            <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-surface-200">
                    <a href="{{ route('domains.concepts.index', $concept->domain) }}" class="text-sm font-medium text-surface-500 hover:text-surface-700 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>