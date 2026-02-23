<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="forest">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Plant ID') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-base-200">
    <div class="navbar bg-base-100 shadow-sm">
        <div class="flex-1">
            <a href="/" class="btn btn-ghost text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                Plant ID
            </a>
        </div>
        <div class="flex-none">
            <a href="/plantId" class="btn btn-primary btn-sm">Identify Plant</a>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8 max-w-2xl">
        {{ $slot }}
    </main>

    <footer class="footer footer-center bg-base-100 text-base-content p-4 mt-auto">
        <aside>
            <p>Plant ID &mdash; Powered by PlantNet API</p>
        </aside>
    </footer>
</body>

</html>
