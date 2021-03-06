<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://fonts.googleapis.com/css2?family=Norican&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <link rel="icon" sizes="192*192" href="logo.png">


        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <style>
            .post{
                position: relative;
                flex: 1 0 22%;
                color: white;
                cursor: pointer;
                width: 293px;
                height: 293px;
            }
            .post:hover .post-info,
            .post:focus .post-info{
                display: flex;
                justify-content: center;
                align-items: center;
                position: absolute;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.3)
            }

            .post-info{
                display: none; 
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header)) 
                {{ $header }}
            @endif

            <!-- Page Content -->
            <main class="mt-10 pb-2">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts


        <script>
            var img = document.getElementById('postImage');
            var sec1 = document.getElementById('sec1');
            var sec3 = document.getElementById('sec3');
            var sec4 = document.getElementById('sec4');

            if(img != null)
            {
                var imageheghit = img.offsetHeight;
                var sec1eheghit = sec1.offsetHeight;
                var sec3eheghit = sec1.offsetHeight;
                var sec4eheghit = sec1.offsetHeight;
                var heghit = imageheghit -(sec1eheghit+sec3eheghit+sec4eheghit);
                document.getElementById("commentarea").style.maxHeight = heghit.toString()+ "px";
            }
        </script>
    </body>
</html>
