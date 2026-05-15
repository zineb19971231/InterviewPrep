<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'InterviewPrep') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-surface-50 text-surface-800 min-h-screen">
        <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
            <aside :class="{
                'translate-x-0': sidebarOpen,
                '-translate-x-full lg:translate-x-0': !sidebarOpen
            }" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-surface-200 transform transition-transform duration-300 lg:static lg:inset-0 lg:z-auto">
                <div class="flex flex-col h-full">
                    <div class="flex items-center h-16 px-6 border-b border-surface-200">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center shadow-soft">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <span class="text-lg font-semibold text-surface-900">InterviewPrep</span>
                        </a>
                    </div>

                    <nav class="flex-1 px-3 py-6 space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-surface-600 hover:bg-surface-100 hover:text-surface-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('domains.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('domains.*') || request()->routeIs('concepts.*') ? 'bg-primary-50 text-primary-700' : 'text-surface-600 hover:bg-surface-100 hover:text-surface-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Domaines
                        </a>

                        <div class="pt-4 mt-4 border-t border-surface-200">
                            <p class="px-3 mb-2 text-xs font-semibold text-surface-400 uppercase tracking-wider">Raccourcis</p>
                            <a href="{{ route('generated-questions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('generated-questions.*') ? 'bg-primary-50 text-primary-700' : 'text-surface-600 hover:bg-surface-100 hover:text-surface-900' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Questions AI
                            </a>
                        </div>
                    </nav>

                    <div x-data="{ userMenu: false }" class="p-4 border-t border-surface-200 relative">
                        <button @click="userMenu = !userMenu" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-surface-50 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 text-sm font-medium flex-shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0 text-left">
                                <p class="text-sm font-medium text-surface-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-surface-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <svg class="w-4 h-4 text-surface-400 transition-transform duration-200" :class="{ 'rotate-180': userMenu }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="userMenu" @click="userMenu = false" class="fixed inset-0 z-10 lg:hidden"></div>

                        <div x-show="userMenu" @click.outside="userMenu = false" class="absolute left-4 right-4 bottom-full mb-2 bg-white rounded-lg shadow-soft-lg border border-surface-200 py-1 overflow-hidden z-20">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-surface-700 hover:bg-surface-50 transition-colors">
                                <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-surface-700 hover:bg-surface-50 transition-colors">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="flex-1 flex flex-col min-w-0">
                <header class="sticky top-0 z-40 h-16 bg-white/80 backdrop-blur-md border-b border-surface-200">
                    <div class="flex items-center justify-between h-full px-4 sm:px-6 lg:px-8">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div class="flex-1 lg:flex-none lg:hidden"></div>

                        <div class="flex items-center gap-4">
                            <div class="hidden sm:flex items-center gap-2 text-sm text-surface-500">
                                <span class="w-2 h-2 rounded-full bg-success-500"></span>
                                <span>En ligne</span>
                            </div>

                            <div class="relative" x-data="{ dropdownOpen: false }">
                                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 transition-colors">
                                    <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10"></div>

                                <div x-show="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-soft-lg border border-surface-200 py-1 z-20">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-surface-700 hover:bg-surface-50 transition-colors">Profil</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-surface-700 hover:bg-surface-50 transition-colors">Déconnexion</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    <div class="animate-[fadeIn_0.3s_ease-out]">
                        {{ $slot }}
                    </div>
                </main>
            </div>

            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-surface-900/30 z-40 lg:hidden"></div>
        </div>
    </body>
</html>