<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Consenso alla Pubblicazione dei Riscontri e delle Testimonianze</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-[#f1ece2]">
        @if(session()->has('form_status'))
            <script>
                window.location.href = '/';
            </script>
        @else
            <section class="h-screen w-full flex flex-col justify-center items-center">
                @livewire('form-consenso-testimonianze')
            </section>
        @endif
    </body>
</html>
