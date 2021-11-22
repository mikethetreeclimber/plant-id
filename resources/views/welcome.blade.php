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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;800&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .hover\:w-full:hover {
            width: 100%;
        }

        .group:hover .group-hover\:w-full {
            width: 100%;
        }

        .group:hover .group-hover\:inline-block {
            display: inline-block;
        }

        .group:hover .group-hover\:flex-grow {
            flex-grow: 1;
        }

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

    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-200">
    <main class="mx-auto bg-gray-300 h-full space-y-4">
        <x-container>
            <div>
                <div class="bg-gray-400 space-y-4 overflow-hidden shadow rounded-lg w-full">
                    <div class="px-4 pt-4 sm:px-6">
                        <div class="border-b border-gray-900 grid grid-cols-3">
                            <div class="flex justify-center items-center">
                                <div x-data="{open: false}" class="relative">
                                    <button @mouseover="open = true" @mouseleave="open = false"
                                        class="text-right px-3 py-2 text-white text-sm font-medium bg-yellow-600 rounded-full">
                                        40.7%
                                    </button>
                                    <div x-show.transition="open" id="popover"
                                        class="p-3 rounded shadow-2xl flex flex-col left-0 max-w-xl bg-white text-sm text-gray-800 mt-3 absolute z-20  w-72"
                                        tabindex="-1">
                                        <p class="font-bold">
                                            Probability this is the correct species
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end col-span-2">
                                <h3 class="text-lg leading-6 font-bold text-gray-900">
                                    Northern Red Oak
                                </h3>
                                <p class="mt-1 max-w-4xl italic text-md text-gray-800">Qurecus rubra</p>
                            </div>

                        </div>
                    </div>
                    <div class="px-4 sm:p-6">
                        <div class="flex items-center justify-center">
                            <div class="w-full max-w-md">
                                <div class="flex">

                                    <div class="flex-auto hover:w-full group">
                                        <button type="button" wire:click="removeResult('0')"
                                            class="flex items-center justify-center text-center mx-auto px-4 py-2 group-hover:w-full text-indigo-500">
                                            <span
                                                class="block px-1 py-1 group-hover:bg-indigo-100 rounded-full group-hover:flex-grow">
                                                <i class="fas fa-question-circle text-2xl pt-1"></i>
                                                <span
                                                    class="hidden group-hover:inline-block ml-3 align-bottom pb-1">Compare</span>
                                            </span>
                                            </a>
                                    </div>
                                    <div class="flex-auto hover:w-full group">
                                        <a href="#"
                                            class="flex items-center justify-center text-center mx-auto px-4 py-2 group-hover:w-full text-red-500">
                                            <span
                                                class="block px-1 py-1 group-hover:bg-indigo-100 rounded-full group-hover:flex-grow">
                                                <i class="far fa-trash text-2xl pt-1"></i><span
                                                    class="hidden group-hover:inline-block ml-3 align-bottom pb-1">Remove</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="flex-auto hover:w-full group">
                                        <button type="button"
                                            class="flex flex-row items-center justify-center mx-auto px-2 py-1 group-hover:w-full rounded-full text-green-900">
                                            <span
                                                class="block px-1 py-1 group-hover:bg-green-600 rounded-full group-hover:flex-grow">
                                                <i class="fas fa-check-circle text-2xl pt-1"></i>
                                                <span
                                                    class="hidden group-hover:inline-block ml-3 align-bottom pb-1">Confirm</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 grid gap-2 grid-cols-2">
                        <div class="mx-auto col-span-2 ">
                            <div
                                class="overflow-hidden p-2 shadow-lg rounded-lg relative w-full h-auto m-auto bg-gray-900">
                                <img alt="uploaded photo"
                                    src="https://bs.plantnet.org/image/o/58ece9592db882d4dcdec90e385fea823558c979"
                                    class="rounded-lg w-full h-full object-fill">
                                <div class="absolute w-full p-2 bottom-1">
                                    <div class="w-10 h-10 md:w-14 md:h-14">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <dl class="mt-1 flex-grow flex flex-col justify-between col-span-2">
                            <dt class="sr-only">Citation</dt>
                            <dd class="text-gray-800 text-sm">Artemiy Alexandrov / Pl@ntNet, cc-by-sa</dd>
                            <dt class="sr-only">Date</dt>
                            <dd class="text-gray-800 text-sm">July 2, 2020</dd>
                        </dl>
                        <div class="col-span-1 w-auto flex justify-center items-center">
                            <div>
                                <button wire:click="back"
                                    class="-translate-y-1/2 w-11 h-11 flex justify-center items-center rounded-full shadow-md z-10 bg-gray-900 hover:bg-gray-500">
                                    <svg class=" w-8 h-8 font-bold transition duration-500 ease-in-out transform motion-reduce:transform-none text-gray-500 hover:text-gray-900 hover:-translate-x-0.5"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 19l-7-7 7-7">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-span-1 w-auto flex justify-center items-center">
                            <div>
                                <button wire:click="next"
                                    class="translate-y-1/2 w-11 h-11 flex justify-center items-center rounded-full shadow-md z-10 bg-gray-900 hover:bg-gray-500">
                                    <svg class=" w-8 h-8 font-bold transition duration-500 ease-in-out transform motion-reduce:transform-none text-gray-500 hover:text-gray-900 hover:translate-x-0.5"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4">

                </div>
            </div>
            </div>
        </x-container>
    </main>

    <script>

    </script>
</body>

</html>
