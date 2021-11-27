<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        @import url(https://pro.fontawesome.com/releases/v5.10.0/css/all.css);

        #popover:before {
            content: "";
            position: absolute;
            bottom: 100%;
            left: 5%;
            margin-left: -10px;
            border-width: 7px;
            border-style: solid;
            border-color: transparent transparent lightgray transparent;
        }

    </style>

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">

        <main class="mx-auto bg-gray-300 h-screen">
          

                {{ $slot }}

               
        </main>

    @stack('modals')

    @livewireScripts
</body>

</html>
