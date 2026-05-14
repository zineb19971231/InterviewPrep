<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InterviewPrep — Préparez vos entretiens techniques</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #EEF2FF 0%, #FFFFFF 50%, #F1F5F9 100%);
        }
    </style>
</head>
<body class="font-sans antialiased bg-surface-50 text-surface-800 min-h-screen">

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-surface-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center shadow-soft">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-surface-900">InterviewPrep</span>
                </a>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-surface-600 hover:text-surface-800 transition-colors">Connexion</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-primary">S'inscrire</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main>
        <section class="hero-gradient py-20 lg:py-28 px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-primary-50 border border-primary-200 text-primary-700 text-sm font-medium mb-6">
                    Propulsé par Groq AI
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-surface-900 mb-6 leading-tight tracking-tight">
                    Préparez vos entretiens<br>
                    <span class="text-primary-600">avec l'intelligence artificielle</span>
                </h1>
                <p class="text-lg sm:text-xl text-surface-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Organisez vos connaissances techniques, suivez votre progression et générez des questions d'entretien réalistes pour décrocher votre prochain job.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary text-base px-8 py-4 shadow-soft-md hover:shadow-soft-lg">
                            Dashboard
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary text-base px-8 py-4 shadow-soft-md hover:shadow-soft-lg">
                            Commencer gratuitement
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary text-base px-8 py-4">
                            Se connecter
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-4 pb-20 -mt-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                <div class="card p-6 hover:shadow-card-hover hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 mb-2">Organisez vos domaines</h3>
                    <p class="text-sm text-surface-500 leading-relaxed">Structurez vos connaissances par technologie : Laravel, PHP, MySQL, Docker, etc.</p>
                </div>

                <div class="card p-6 hover:shadow-card-hover hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-success-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 mb-2">Suivez votre progression</h3>
                    <p class="text-sm text-surface-500 leading-relaxed">Marquez vos concepts comme "À revoir", "En cours" ou "Maîtrisé" et visualisez votre avancement.</p>
                </div>

                <div class="card p-6 hover:shadow-card-hover hover:-translate-y-0.5 transition-all duration-300 sm:col-span-2 lg:col-span-1">
                    <div class="w-12 h-12 rounded-xl bg-warning-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 mb-2">Générez des questions IA</h3>
                    <p class="text-sm text-surface-500 leading-relaxed">Obtenez 5 questions d'entretien techniques réalistes pour chaque concept via Groq API.</p>
                </div>
            </div>

            <div class="bg-white border border-surface-200 rounded-2xl shadow-soft-lg overflow-hidden">
                <div class="grid lg:grid-cols-2">
                    <div class="p-8 lg:p-12">
                        <h2 class="text-2xl font-bold text-surface-900 mb-6">Comment ça marche ?</h2>
                        <ol class="space-y-6">
                            <li class="flex gap-4">
                                <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-primary-50 text-primary-600 text-sm font-bold flex items-center justify-center">1</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-surface-800">Créez un domaine</h4>
                                    <p class="text-sm text-surface-500">Ajoutez une technologie ou un sujet que vous préparez.</p>
                                </div>
                            </li>
                            <li class="flex gap-4">
                                <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-primary-50 text-primary-600 text-sm font-bold flex items-center justify-center">2</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-surface-800">Ajoutez des concepts</h4>
                                    <p class="text-sm text-surface-500">Détaillez chaque notion avec une explication complète.</p>
                                </div>
                            </li>
                            <li class="flex gap-4">
                                <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-primary-50 text-primary-600 text-sm font-bold flex items-center justify-center">3</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-surface-800">Générez des questions</h4>
                                    <p class="text-sm text-surface-500">L'IA génère 5 questions techniques sur mesure pour vous entraîner.</p>
                                </div>
                            </li>
                        </ol>
                    </div>
                    <div class="bg-surface-50 p-8 lg:p-12 border-t lg:border-t-0 lg:border-l border-surface-200 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-soft-lg">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <p class="text-surface-500 text-sm max-w-xs">Propulsé par <span class="text-primary-600 font-medium">Groq API</span> — modèle LLaMA pour des questions techniques réalistes</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="border-t border-surface-200 py-8 text-center">
            <p class="text-sm text-surface-400">InterviewPrep &copy; {{ date('Y') }} — Préparez vos entretiens techniques en toute confiance</p>
        </footer>
    </main>
</body>
</html>