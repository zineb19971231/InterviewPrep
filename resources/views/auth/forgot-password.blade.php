<x-guest-layout>
    <div class="text-sm text-surface-600 mb-4 leading-relaxed">
        Mot de passe oublié ? Pas de problème. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="vous@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
            Envoyer le lien de réinitialisation
        </button>

        <div class="text-center pt-2">
            <a class="text-sm text-primary-600 hover:text-primary-500 font-medium transition-colors" href="{{ route('login') }}">
                Retour à la connexion
            </a>
        </div>
    </form>
</x-guest-layout>