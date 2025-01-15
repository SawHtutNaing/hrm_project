<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="  h-screen">
            <livewire:components.navigation />
          


            @if (isset($header))
                <header class="bg-primary shadow h-[8vh] flex items-center">
                    <div class="w-4/5 mx-auto py-4 px-6 flex justify-end items-center gap-3">
                        {{ $header }}
                    </div>
                </header>
            @endif

            
            <main>
                <div class="flex h-screen flex-row">
                    <livewire:side-nav />
                    {{ $slot }}
                </div>
            </main>
        </div>
        @livewireScripts
        @livewireStyles

    </body>
</html>
