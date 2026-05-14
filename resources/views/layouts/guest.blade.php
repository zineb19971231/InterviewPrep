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
        <div class="min-h-screen flex flex-col items-center justify-center p-4 relative">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-50/40 via-white to-surface-100/60 pointer-events-none"></div>

            <div class="relative z-10 w-full max-w-md">
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-primary-600 flex items-center justify-center shadow-soft-md">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                    </a>
                    <h1 class="text-2xl font-bold text-surface-900">InterviewPrep</h1>
                    <p class="mt-2 text-surface-500">Préparez vos entretiens techniques en toute confiance</p>
                </div>

                <div class="bg-white border border-surface-200 rounded-2xl shadow-soft-lg p-8">
                    {{ $slot }}
                </div>

                <p class="mt-8 text-center text-sm text-surface-400">
                    &copy; {{ date('Y') }} InterviewPrep. Tous droits réservés.
                </p>
            </div>
        </div>
    </body>
</html>