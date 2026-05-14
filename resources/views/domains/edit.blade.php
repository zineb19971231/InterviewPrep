<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('domains.index') }}" class="inline-flex items-center gap-2 text-sm text-surface-500 hover:text-surface-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux domaines
            </a>
        </div>

        <div class="card">
            <div class="px-6 py-5 border-b border-surface-200">
                <h1 class="text-xl font-bold text-surface-900">Modifier le domaine</h1>
                <p class="mt-1 text-sm text-surface-500">Mettez à jour les informations du domaine</p>
            </div>

            <form method="POST" action="{{ route('domains.update', $domain) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-surface-700 mb-2">Nom du domaine</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $domain->name) }}" required
                           class="input"
                           placeholder="Ex: Laravel ORM, PHP OOP, MySQL...">
                    @error('name')
                        <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-surface-700 mb-3">Couleur du badge</label>
                    <div class="grid grid-cols-4 gap-3">
                        @foreach(['#3B82F6' => 'Bleu', '#10B981' => 'Vert', '#F59E0B' => 'Ambre', '#EF4444' => 'Rouge', '#8B5CF6' => 'Violet', '#EC4899' => 'Rose', '#06B6D4' => 'Cyan', '#F97316' => 'Orange'] as $color => $label)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="color" value="{{ $color }}" {{ old('color', $domain->color) == $color ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-full aspect-square rounded-xl border-2 border-surface-200 transition-all duration-200 flex items-center justify-center peer-checked:border-surface-900 peer-checked:ring-2 peer-checked:ring-primary-500 peer-checked:ring-offset-2 group-hover:scale-105" style="background-color: {{ $color }}">
                                    @if(old('color', $domain->color) == $color)
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @endif
                                </div>
                                <span class="block mt-1 text-center text-xs text-surface-500 group-hover:text-surface-700 transition-colors">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('color')
                        <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-surface-200">
                    <a href="{{ route('domains.index') }}" class="text-sm font-medium text-surface-500 hover:text-surface-700 transition-colors">
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