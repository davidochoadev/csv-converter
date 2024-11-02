<?php

use Livewire\Volt\Component;
use App\Models\FeedbackUser;
use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component {
    public $nome;
    public $cognome;
    public $email;
    public $telefono;
    public $scelta_consenso_1;
    public $scelta_consenso_2;
    public $scelta_consenso_3;
    public $step;
    public $start_date;

    public function mount()
    {
        $this->start_date = session()->get('start_date', now()->format('d-m-Y H:i:s', 'Europe/Rome'));
        $this->step = session()->get('currentstep', 1);
        $this->dati_personali = session()->get('dati_personali', []);
        $this->nome = $this->dati_personali['nome'] ?? '';
        $this->cognome = $this->dati_personali['cognome'] ?? '';
        $this->email = $this->dati_personali['email'] ?? '';
        $this->telefono = $this->dati_personali['telefono'] ?? '';
        $this->scelta_consenso_1 = session()->get('scelta_consenso_1', null);
        $this->scelta_consenso_2 = session()->get('scelta_consenso_2', null);
        $this->scelta_consenso_3 = session()->get('scelta_consenso_3', null);
    }

    public function rules()
    {
        return [
            'nome' => 'required',
            'cognome' => 'required',
            'email' => 'required|email',
            'telefono' => 'required|numeric|digits:10',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Il :attribute è un campo obbligatorio.',
            'cognome.required' => 'Il :attribute è un campo obbligatorio.',
            'email.required' => 'La :attribute è un campo obbligatorio.',
            'telefono.required' => 'Il :attribute è un campo obbligatorio.',
            'scelta_consenso_1.required' => 'Il :attribute è un campo obbligatorio.',
            'scelta_consenso_2.required' => 'Il :attribute è un campo obbligatorio.',
            'scelta_consenso_3.required' => 'Il :attribute è un campo obbligatorio.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'nome' => 'Nominativo',
            'cognome' => 'Cognome',
            'email' => 'Email',
            'telefono' => 'Numero di cellulare',
            'scelta_consenso_1' => 'Consenso',
            'scelta_consenso_2' => 'Consenso',
            'scelta_consenso_3' => 'Consenso',
        ];
    }

    public function firstStep()
    {
        $this->validate([
            'nome' => 'required',
            'cognome' => 'required',
            'email' => 'required|email',
            'telefono' => 'required|numeric|digits:10',
        ]);
        $this->step++;
        session()->put('currentstep', $this->step);
        session()->put('dati_personali', [
            'nome' => $this->nome,
            'cognome' => $this->cognome,
            'email' => $this->email,
            'telefono' => $this->telefono,
        ]);
    }

    public function secondStep()
    {
        $this->validate([
            'scelta_consenso_1' => 'required',
        ]);
        $this->step++;
        session()->put('currentstep', $this->step);
        session()->put('scelta_consenso_1', $this->scelta_consenso_1);
    }

    public function thirdStep()
    {
        $this->validate([
            'scelta_consenso_2' => 'required',
        ]);
        $this->step++;
        session()->put('currentstep', $this->step);
        session()->put('scelta_consenso_2', $this->scelta_consenso_2);
    }

    public function previousStep()
    {
        $this->step--;
        session()->put('currentstep', $this->step);
    }

    public function sceltaConsenso($scelta)
    {
        session()->put('scelta_consenso_1', $scelta);
    }

    public function sceltaConsenso2($scelta)
    {
        session()->put('scelta_consenso_2', $scelta);
    }

    public function sceltaConsenso3($scelta)
    {
        session()->put('scelta_consenso_3', $scelta);
    }

    public function invia()
    {
        $submit_date = now()->format('d-m-Y H:i:s', 'Europe/Rome');
        $form_token = Str::random(32);
        $this->validate([
            'scelta_consenso_3' => 'required',
        ]);

        $feedbackUser = FeedbackUser::create([
            'type_form' => $form_token,
            'first_name' => $this->nome,
            'last_name' => $this->cognome,
            'phone_number' => $this->telefono,
            'first_consent' => $this->scelta_consenso_1 === 'acconsento' ? true : false,
            'second_consent' => $this->scelta_consenso_2 === 'acconsento' ? true : false,
            'third_consent' => $this->scelta_consenso_3 === 'acconsento' ? true : false,
            'submit_date' => $submit_date,
            'start_date' => $this->start_date,
        ]);

        if ($feedbackUser) {
            // Cancella tutti i dati del form
            $this->reset(['nome', 'cognome', 'email', 'telefono', 'scelta_consenso_1', 'scelta_consenso_2', 'scelta_consenso_3', 'start_date']);

            // Cancella i dati dalla sessione
            session()->forget(['dati_personali', 'scelta_consenso', 'scelta_consenso_1', 'scelta_consenso_2', 'scelta_consenso_3', 'start_date', 'submit_date', 'currentstep']);

            // Imposta form_status su success
            session()->put('form_status', 'success');
            session()->put('type_form_token', $form_token);
/*             $feedbackUserArray = $feedbackUser->toArray();
            $pdf = Pdf::loadView('pdf.feedback-user', $feedbackUserArray);
            //return $pdf->download('aaa.pdf');
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, $feedbackUserArray['first_name'] . '_' . $feedbackUserArray['last_name'] . '_' . date('d-m-Y', strtotime($feedbackUserArray['submit_date'])) . '.pdf');
 */
            return redirect('/');
        }
    }
}; ?>

<form wire:submit.prevent="invia">
    @csrf
    <div class="max-w-2xl mx-auto px-4">
        <!-- Step 1 -->
        <section x-show="$wire.step === 1" class="flex flex-col gap-4">
            <!-- TITOLO -->
            <div class="flex flex-col">
                <h2 class="text-2xl font-bold text-slate-700 flex flex-row items-center">MODULO DI RACCOLTA DATI
                    PERSONALI
                    <span class="ml-1"><svg width="24" height="24" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M12 7a1 1 0 0 1 1 1v2.268l1.964-1.134a1 1 0 1 1 1 1.732L14 12l1.964 1.134a1 1 0 0 1-1 1.732L13 13.732V16a1 1 0 1 1-2 0v-2.268l-1.964 1.134a1 1 0 1 1-1-1.732L10 12l-1.964-1.134a1 1 0 1 1 1-1.732L11 10.268V8a1 1 0 0 1 1-1" />
                        </svg></span>
                </h2>
                <p class="flex flex-row items-center text-slate-600 font-light text-xs">
                    <span class="mr-1"><svg width="12" height="12" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M12 7a1 1 0 0 1 1 1v2.268l1.964-1.134a1 1 0 1 1 1 1.732L14 12l1.964 1.134a1 1 0 0 1-1 1.732L13 13.732V16a1 1 0 1 1-2 0v-2.268l-1.964 1.134a1 1 0 1 1-1-1.732L10 12l-1.964-1.134a1 1 0 1 1 1-1.732L11 10.268V8a1 1 0 0 1 1-1" />
                        </svg></span>
                    Modulo obbligatorio
                </p>
            </div>
            <!-- DESCRIZIONE -->
            <p class="text-slate-600 font-light text-base">
                Per poter procedere con la raccolta dei consensi necessari alla condivisione delle informazioni, le
                viene chiesto di fornire i suoi dati personali.<br>
                Queste informazioni saranno utilizzate esclusivamente per identificarla e per gestire i consensi
                relativi alla privacy e alla pubblicazioni di riscontri, testimonianze e feedback.
            </p>
            <!-- INFORMAZIONI PERSONALI -->
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-1">
                    <label for="nome" class="text-slate-600 font-light text-sm">Nome *</label>
                    <input type="text" id="nome" wire:model="nome" placeholder="Mario"
                        class="border-0 border-b border-slate-400 rounded-0 p-2 text-slate-600 font-semibold text-base bg-transparent focus:outline-none ring-0 focus:ring-0 focus:border-slate-500 focus:border-b-2 placeholder:text-slate-400 placeholder:font-medium"
                        autocomplete="off">
                    @error('nome')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label for="cognome" class="text-slate-600 font-light text-sm">Cognome *</label>
                    <input type="text" id="cognome" wire:model="cognome" placeholder="Rossi"
                        class="border-0 border-b border-slate-400 rounded-0 p-2 text-slate-600 font-semibold text-base bg-transparent focus:outline-none ring-0 focus:ring-0 focus:border-slate-500 focus:border-b-2 placeholder:text-slate-400 placeholder:font-medium"
                        autocomplete="off">
                    @error('cognome')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label for="email" class="text-slate-600 font-light text-sm">Email</label>
                    <input type="email" id="email" wire:model="email" placeholder="mario.rossi@example.com"
                        class="border-0 border-b border-slate-400 rounded-0 p-2 text-slate-600 font-semibold text-base bg-transparent focus:outline-none ring-0 focus:ring-0 focus:border-slate-500 focus:border-b-2 placeholder:text-slate-400 placeholder:font-medium"
                        autocomplete="off">
                    @error('email')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label for="telefono" class="text-slate-600 font-light text-sm">Telefono *</label>
                    <input type="tel" id="telefono" wire:model="telefono" placeholder="321 345 6789"
                        class="border-0 border-b border-slate-400 rounded-0 p-2 text-slate-600 font-semibold text-base bg-transparent focus:outline-none ring-0 focus:ring-0 focus:border-slate-500 focus:border-b-2 placeholder:text-slate-400 placeholder:font-medium"
                        autocomplete="off">
                    @error('telefono')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <!-- BUTTONS --->
            <div class="mt-4 flex justify-end">
                <button type="button" wire:click="firstStep"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Prosegui
                </button>
            </div>
        </section>

        <!-- Step 2 -->
        <section x-show="$wire.step === 2" class="flex flex-col gap-4">
            <!-- TITOLO -->
            <div class="flex flex-col">
                <h2 class="text-2xl font-bold text-slate-700 flex flex-row items-center">Acconsente alla condivisione di
                    riscontri, testimonianze e feedback - da Lei espressi/e privatamente - sul lavoro svolto dalla
                    sottoscritta in suo favore e sull'attività che essa gestisce?
                    <span class="ml-1"><svg width="24" height="24" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M12 7a1 1 0 0 1 1 1v2.268l1.964-1.134a1 1 0 1 1 1 1.732L14 12l1.964 1.134a1 1 0 0 1-1 1.732L13 13.732V16a1 1 0 1 1-2 0v-2.268l-1.964 1.134a1 1 0 1 1-1-1.732L10 12l-1.964-1.134a1 1 0 1 1 1-1.732L11 10.268V8a1 1 0 0 1 1-1" />
                        </svg></span>
                </h2>
                <p class="flex flex-row items-center text-slate-600 font-light text-xs">
                    <span class="mr-1"><svg width="12" height="12" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M12 7a1 1 0 0 1 1 1v2.268l1.964-1.134a1 1 0 1 1 1 1.732L14 12l1.964 1.134a1 1 0 0 1-1 1.732L13 13.732V16a1 1 0 1 1-2 0v-2.268l-1.964 1.134a1 1 0 1 1-1-1.732L10 12l-1.964-1.134a1 1 0 1 1 1-1.732L11 10.268V8a1 1 0 0 1 1-1" />
                        </svg></span>
                    Modulo obbligatorio
                </p>
            </div>
            <!-- DESCRIZIONE -->
            <p class="text-slate-600 font-light text-base">
                I suoi dati personali, sensibili (quali nome, cognome, numero di telefono, codice fiscale, indirizzo ed
                e-mail), saranno sempre mantenuti anonimi, ma alcuni estratti delle nostre conversazioni verranno resi
                pubblici con l'intento di facilitare la comprensione generale verso certe prestazioni olistiche. Oltre a
                chiarire la natura dei servizi, i suoi riscontri aiuteranno a confermare l'efficacia delle pratiche
                proposte, fornendo utili indicazioni a chiunque sia interessato a richiedere un servizio simile, sia per
                curiosità che per necessità.
            </p>
            <!-- CHECKBOX -->
            <div class="flex flex-col gap-2">
                @error('scelta_consenso_1')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
                <div class="flex flex-row items-center gap-2">
                    <div class="relative">
                        <input wire:click="sceltaConsenso('acconsento')" type="radio" id="consenso"
                            name="scelta_consenso_1" wire:model="scelta_consenso_1" value="acconsento"
                            class="appearance-none w-5 h-5 border-2 border-slate-600 rounded-sm bg-white checked:bg-slate-600 checked:border-0 transition-all duration-200 cursor-pointer focus:bg-slate-600 focus:border-slate-600"
                            {{ session('scelta_consenso_1') === 'acconsento' ? 'checked' : '' }}>
                        <svg class="absolute w-3 h-3 top-1 left-1 pointer-events-none hidden text-white"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <label for="consenso" class="text-slate-600 font-light text-sm cursor-pointer">Acconsento</label>
                </div>
                <div class="flex flex-row items-center gap-2">
                    <div class="relative">
                        <input wire:click="sceltaConsenso('non_acconsento')" type="radio" id="non-consenso"
                            name="scelta_consenso_1" wire:model="scelta_consenso_1" value="non_acconsento"
                            class="appearance-none w-5 h-5 border-2 border-slate-600 rounded-sm bg-white checked:bg-slate-600 checked:border-0 transition-all duration-200 cursor-pointer focus:bg-slate-600 focus:border-slate-600"
                            {{ session('scelta_consenso_1') === 'non_acconsento' ? 'checked' : '' }}>
                        <svg class="absolute w-3 h-3 top-1 left-1 pointer-events-none hidden text-white"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <label for="non-consenso" class="text-slate-600 font-light text-sm cursor-pointer">Non
                        acconsento</label>
                </div>
            </div>
            <!-- BUTTONS -->
            <div class="mt-4 flex justify-between">
                <button type="button" wire:click="previousStep"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Torna Indietro
                </button>
                <button type="button" wire:click="secondStep"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Prosegui
                </button>
            </div>
        </section>

        <!-- Step 3 -->
        <section x-show="$wire.step === 3" class="flex flex-col gap-4">
            <!-- TITOLO -->
            <div class="flex flex-col">
                <h2 class="text-2xl font-bold text-slate-700 flex flex-row items-center">Conferma di essere pienamente
                    in grado di intendere e volere e di accettare i termini riguardanti la condivisione di estratti
                    delle conversazioni?
                    <span class="ml-1"><svg width="24" height="24" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M12 7a1 1 0 0 1 1 1v2.268l1.964-1.134a1 1 0 1 1 1 1.732L14 12l1.964 1.134a1 1 0 0 1-1 1.732L13 13.732V16a1 1 0 1 1-2 0v-2.268l-1.964 1.134a1 1 0 1 1-1-1.732L10 12l-1.964-1.134a1 1 0 1 1 1-1.732L11 10.268V8a1 1 0 0 1 1-1" />
                        </svg></span>
                </h2>
                <p class="flex flex-row items-center text-slate-600 font-light text-xs">
                    <span class="mr-1"><svg width="12" height="12" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M12 7a1 1 0 0 1 1 1v2.268l1.964-1.134a1 1 0 1 1 1 1.732L14 12l1.964 1.134a1 1 0 0 1-1 1.732L13 13.732V16a1 1 0 1 1-2 0v-2.268l-1.964 1.134a1 1 0 1 1-1-1.732L10 12l-1.964-1.134a1 1 0 1 1 1-1.732L11 10.268V8a1 1 0 0 1 1-1" />
                        </svg></span>
                    Modulo obbligatorio
                </p>
            </div>
            <!-- DESCRIZIONE -->
            <p class="text-slate-600 font-light text-base">
                Confermando quanto soprascritto, dichiara di possedere la piena capacità di intendere e volere e di
                accettare la condivisione di estratti delle nostre conversazioni a fini informativi, mantenendo
                l'anonimato dei suoi dati personali. Dando conferma riconosce altresì che, in qualsiasi momento e senza
                necessità di motivazione, ha il diritto di richiedere la cancellazione di tali estratti, in conformità
                con il suo diritto alla privacy.
            </p>
            <!-- CHECKBOX -->
            <div class="flex flex-col gap-2">
                @error('scelta_consenso_2')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
                <div class="flex flex-row items-center gap-2">
                    <div class="relative">
                        <input wire:click="sceltaConsenso2('acconsento')" type="radio" id="consenso"
                            name="scelta_consenso_2" wire:model="scelta_consenso_2" value="acconsento"
                            class="appearance-none w-5 h-5 border-2 border-slate-600 rounded-sm bg-white checked:bg-slate-600 checked:border-0 transition-all duration-200 cursor-pointer focus:bg-slate-600 focus:border-slate-600"
                            {{ session('scelta_consenso_2') === 'acconsento' ? 'checked' : '' }}>
                        <svg class="absolute w-3 h-3 top-1 left-1 pointer-events-none hidden text-white"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <label for="consenso" class="text-slate-600 font-light text-sm cursor-pointer">Acconsento</label>
                </div>
                <div class="flex flex-row items-center gap-2">
                    <div class="relative">
                        <input wire:click="sceltaConsenso2('non_acconsento')" type="radio" id="non-consenso"
                            name="scelta_consenso_2" wire:model="scelta_consenso_2" value="non_acconsento"
                            class="appearance-none w-5 h-5 border-2 border-slate-600 rounded-sm bg-white checked:bg-slate-600 checked:border-0 transition-all duration-200 cursor-pointer focus:bg-slate-600 focus:border-slate-600"
                            {{ session('scelta_consenso_2') === 'non_acconsento' ? 'checked' : '' }}>
                        <svg class="absolute w-3 h-3 top-1 left-1 pointer-events-none hidden text-white"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <label for="non-consenso" class="text-slate-600 font-light text-sm cursor-pointer">Non
                        acconsento</label>
                </div>
            </div>
            <!-- BUTTONS -->
            <div class="mt-4 flex justify-between">
                <button type="button" wire:click="previousStep"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Torna Indietro
                </button>
                <button type="button" wire:click="thirdStep"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Prosegui
                </button>
            </div>
        </section>

        <!-- Step 4 -->
        <section x-show="$wire.step === 4" class="flex flex-col gap-4">
            <!-- TITOLO -->
            <div class="flex flex-col">
                <h2 class="text-2xl font-bold text-slate-700 flex flex-row items-center">Conferma che i consensi
                    forniti o negati nei precedenti moduli sono legati ai dati personali da Lei inseriti all'inizio?
                    <span class="ml-1"><svg width="24" height="24" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M12 7a1 1 0 0 1 1 1v2.268l1.964-1.134a1 1 0 1 1 1 1.732L14 12l1.964 1.134a1 1 0 0 1-1 1.732L13 13.732V16a1 1 0 1 1-2 0v-2.268l-1.964 1.134a1 1 0 1 1-1-1.732L10 12l-1.964-1.134a1 1 0 1 1 1-1.732L11 10.268V8a1 1 0 0 1 1-1" />
                        </svg></span>
                </h2>
                <p class="flex flex-row items-center text-slate-600 font-light text-xs">
                    <span class="mr-1"><svg width="12" height="12" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M12 7a1 1 0 0 1 1 1v2.268l1.964-1.134a1 1 0 1 1 1 1.732L14 12l1.964 1.134a1 1 0 0 1-1 1.732L13 13.732V16a1 1 0 1 1-2 0v-2.268l-1.964 1.134a1 1 0 1 1-1-1.732L10 12l-1.964-1.134a1 1 0 1 1 1-1.732L11 10.268V8a1 1 0 0 1 1-1" />
                        </svg></span>
                    Modulo obbligatorio
                </p>
            </div>
            <!-- DESCRIZIONE -->
            <p class="text-slate-600 font-light text-base">
                Per garantire la corretta gestione dei suoi consensi relativi alla privacy e alla condivisione di
                riscontri, testimonianze e feedback, le viene chiesto di confermare che i dati personali inseriti nel
                primo modulo compilato siano veritieri ed identificativi della sua persona, così da poterli utilizzare
                in maniera coerente per collegare tutti i consensi espressi o negati nei moduli successivi. Suddetta
                procedura ci aiuterà a rispettare i suoi diritti alla privacy e a gestire in modo sicuro e trasparente
                le sue informazioni.
            </p>
            <!-- CHECKBOX -->
            <div class="flex flex-col gap-2">
                @error('scelta_consenso_3')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
                <div class="flex flex-row items-center gap-2">
                    <div class="relative">
                        <input wire:click="sceltaConsenso3('acconsento')" type="radio" id="consenso"
                            name="scelta_consenso_3" wire:model="scelta_consenso_3" value="acconsento"
                            class="appearance-none w-5 h-5 border-2 border-slate-600 rounded-sm bg-white checked:bg-slate-600 checked:border-0 transition-all duration-200 cursor-pointer focus:bg-slate-600 focus:border-slate-600"
                            {{ session('scelta_consenso_3') === 'acconsento' ? 'checked' : '' }}>
                        <svg class="absolute w-3 h-3 top-1 left-1 pointer-events-none hidden text-white"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <label for="consenso" class="text-slate-600 font-light text-sm cursor-pointer">Acconsento</label>
                </div>
                <div class="flex flex-row items-center gap-2">
                    <div class="relative">
                        <input wire:click="sceltaConsenso3('non_acconsento')" type="radio" id="non-consenso"
                            name="scelta_consenso_3" wire:model="scelta_consenso_3" value="non_acconsento"
                            class="appearance-none w-5 h-5 border-2 border-slate-600 rounded-sm bg-white checked:bg-slate-600 checked:border-0 transition-all duration-200 cursor-pointer focus:bg-slate-600 focus:border-slate-600"
                            {{ session('scelta_consenso_3') === 'non_acconsento' ? 'checked' : '' }}>
                        <svg class="absolute w-3 h-3 top-1 left-1 pointer-events-none hidden text-white"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <label for="non-consenso" class="text-slate-600 font-light text-sm cursor-pointer">Non
                        acconsento</label>
                </div>
            </div>
            <div class="mt-4 flex justify-between">
                <button type="button" wire:click="previousStep"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Torna Indietro
                </button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Invia
                </button>
            </div>
        </section>
    </div>
</form>
