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
            <section class="h-screen w-full flex flex-col justify-center items-center gap-4">
                <h1 class="text-4xl font-bold text-slate-600">Grazie per aver compilato il modulo! 🥳🎉</h1>
                @livewire('download-pdf')
            </section>
        @else
            <section class="h-screen w-full flex flex-col justify-center items-center gap-4">
                <h1 class="text-4xl font-bold text-slate-600">Consenso alla Pubblicazione dei Riscontri e delle Testimonianze</h1>
                <p class="text-slate-600 text-center mt-4">
                    Vorremmo condividere la tua esperienza per aiutare altri clienti a conoscere meglio i nostri servizi.<br>
                    Ti chiediamo il permesso di utilizzare in modo anonimo alcuni riscontri o testimonianze che ci hai fornito.<br>
                    Puoi scegliere se acconsentire o meno alla loro pubblicazione. 🙏🍃
                </p>
                @if(session('scelta_consenso') === null)
                    <a href="/consenso-testimonianze" class="font-semibold mt-4 px-6 py-3 bg-slate-500 text-white rounded-lg hover:bg-slate-700 transition duration-300">Compila il modulo ✍️</a>
                @else
                    <a href="/consenso-testimonianze" class="font-semibold mt-4 px-6 py-3 bg-slate-500 text-white rounded-lg hover:bg-slate-700 transition duration-300">Continua con il tuo consenso ✍️</a>
                @endif
            </section>
        @endif
    </body>
</html>
