<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-8">
        <div>
            <h1 class="page-title">Profil</h1>
            <p class="page-subtitle">Gérez vos informations personnelles et votre mot de passe</p>
        </div>

        <div class="card">
            <div class="p-6 lg:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="card">
            <div class="p-6 lg:p-8">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="card">
            <div class="p-6 lg:p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>