<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InterviewPrep - Boost your career</title>
    @vite(['resources/css/app.js', 'resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script> <!-- Au cas où Vite a encore des soucis -->
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <!-- Navigation -->
    <nav class="flex items-center justify-between p-6 bg-white shadow-sm">
        <div class="text-2xl font-bold text-indigo-600">InterviewPrep</div>
        <div class="space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 font-semibold text-gray-600 hover:text-indigo-600">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">S'inscrire</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="py-16 px-6 text-center">
        <h1 class="text-5xl font-extrabold mb-4">Préparez vos entretiens avec <span class="text-indigo-600">l'IA</span></h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Organisez vos connaissances techniques et générez des questions réalistes pour décrocher votre prochain job à Casablanca.</p>
    </header>

    <main class="max-w-6xl mx-auto p-6 space-y-12">
        
        <!-- Section Domaines (US2 & US3) -->
        <section>
            <h2 class="text-2xl font-bold mb-6 flex items-center italic">
                <span class="bg-indigo-100 text-indigo-600 p-2 rounded-md mr-2">#</span> Mes Domaines Techniques
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card Domaine 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
                    <h3 class="text-xl font-bold">Laravel ORM</h3>
                    <p class="text-sm text-gray-500 mt-2">12 Concepts • 8 Maîtrisés</p>
                    <div class="w-full bg-gray-200 h-2 rounded-full mt-4">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 66%"></div>
                    </div>
                </div>
                <!-- Card Domaine 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500 hover:shadow-md transition">
                    <h3 class="text-xl font-bold">PHP OOP</h3>
                    <p class="text-sm text-gray-500 mt-2">5 Concepts • 2 Maîtrisés</p>
                    <div class="w-full bg-gray-200 h-2 rounded-full mt-4">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: 40%"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Concepts & AI (US5 & US11) -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Liste des concepts -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold mb-4 italic text-gray-700 underline">Détail du Concept : Eloquent N+1</h3>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Le problème N+1 survient lorsque l'on charge une collection de modèles puis que l'on accède à une relation pour chaque modèle, créant ainsi plusieurs requêtes SQL inutiles...
                </p>
                <div class="flex gap-2">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Maîtrisé</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase">Mid-Level</span>
                </div>
            </div>

            <!-- Questions générées par l'IA -->
            <div class="bg-indigo-900 text-white p-8 rounded-2xl shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 text-6xl font-bold">AI</div>
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    ✨ Questions d'entretien (Groq AI)
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="bg-indigo-700 p-1 rounded">01</span>
                        <p class="text-indigo-100 italic">"Expliquez la différence entre eager loading et lazy loading dans Laravel."</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="bg-indigo-700 p-1 rounded">02</span>
                        <p class="text-indigo-100 italic">"Comment utiliser la méthode withCount() pour optimiser vos requêtes ?"</p>
                    </li>
                </ul>
                <button class="mt-8 w-full py-3 bg-white text-indigo-900 font-bold rounded-lg hover:bg-indigo-50 transition uppercase tracking-wider text-sm">
                    Générer de nouvelles questions
                </button>
            </div>
        </section>
    </main>

    <footer class="text-center py-10 text-gray-400 text-sm">
        InterviewPrep &copy; 2026 - Sprint Projet Casablanca
    </footer>
</body>
</html>