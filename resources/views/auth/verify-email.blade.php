<x-guest-layout>
    <div class="text-sm text-surface-600 mb-4 leading-relaxed">
        Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.
    </div>

    @if(session('status') == 'verification-link-sent')
        <div class="mb-4 px-4 py-3 bg-success-50 border border-success-200 text-success-700 rounded-xl text-sm">
            Un nouveau lien de vérification a été envoyé à votre adresse email.
        </div>
    @endif

    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">
                Renvoyer l'email de vérification
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-surface-500 hover:text-surface-700 transition-colors font-medium">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>