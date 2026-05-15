<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-surface-900">Supprimer le compte</h2>
        <p class="mt-1 text-sm text-surface-500 leading-relaxed">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-danger-50 hover:bg-danger-100 text-danger-700 font-medium text-sm rounded-lg transition-all duration-200 border border-danger-200 hover:border-danger-300">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        Supprimer le compte
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-6">
            @csrf
            @method('delete')

            <div>
                <h2 class="text-lg font-semibold text-surface-900">Êtes-vous sûr de vouloir supprimer votre compte ?</h2>
                <p class="mt-2 text-sm text-surface-600 leading-relaxed">
                    Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
                    Veuillez entrer votre mot de passe pour confirmer.
                </p>
            </div>

            <div>
                <x-input-label for="password" value="{{ __('Mot de passe') }}" />
                <x-text-input id="password" name="password" type="password" class="block w-full mt-1" placeholder="Entrez votre mot de passe" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="btn-secondary">Annuler</button>
                <button type="submit" class="btn-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer définitivement
                </button>
            </div>
        </form>
    </x-modal>
</section>