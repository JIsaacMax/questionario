<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ request()->cookie('theme', '') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('title', 'Questionario Unifagoc') }}</title>

    <!-- Fonts -->
    <link rel="icon" type="image/png" href="{{ asset('assets/LogoUni.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-100 antialiased">

    <!-- Navbar Tailwind -->
    <nav class="bg-white dark:bg-gray-900 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <img src="{{ asset('assets/LogoUni.png') }}" alt="Logo" class="h-10">
                <a href="{{ route('questionarios.index') }}"
                    class="text-xl font-bold text-indigo-600 hover:text-indigo-700">
                    Questionários
                </a>
                <div class="flex space-x-4">
                    <a href="{{ route('questionarios.index') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 transition">
                        Lista
                    </a>
                    <a href="{{ route('questionarios.create') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700 transition">
                        Novo
                    </a>
                </div>
                <button id="theme-toggle" type="button" onclick="toggleDarkMode()"
                    class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors text-gray-800 dark:text-gray-100">
                    <!-- Ícone sol/lua SVG -->
                    <svg id="theme-icon" viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <!-- Ícone do sol (padrão, será trocado via JS) -->
                        <circle cx="12" cy="12" r="5"></circle>
                        <path d="M12 1v2"></path>
                        <path d="M12 21v2"></path>
                        <path d="M4.22 4.22l1.42 1.42"></path>
                        <path d="M18.36 18.36l1.42 1.42"></path>
                        <path d="M1 12h2"></path>
                        <path d="M21 12h2"></path>
                        <path d="M4.22 19.78l1.42-1.42"></path>
                        <path d="M18.36 5.64l1.42-1.42"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const html = document.documentElement;
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme === 'dark') {
                html.classList.add('dark');
            }

            window.toggleDarkMode = function() {
                html.classList.toggle('dark');
                const theme = html.classList.contains('dark') ? 'dark' : 'light';
                localStorage.setItem('theme', theme);
            };
        });
    </script>
</body>

</html>