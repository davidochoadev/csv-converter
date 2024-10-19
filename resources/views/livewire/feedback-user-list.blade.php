<?php

use Livewire\Volt\Component;
use App\Models\FeedbackUser;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component {
    use WithPagination;

    public function delete($id)
    {
        FeedbackUser::find($id)->delete();
        $this->dispatch('refresh');
    }

    public function downloadPdf($feedbackUser)
    {
        $pdf = Pdf::loadView('pdf.feedback-user', $feedbackUser);
        //return $pdf->download('aaa.pdf');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'aaa.pdf');
    }

    public function with(): array
    {
        return [
            'feedbackUsers' => FeedbackUser::latest()->paginate(10),
        ];
    }
}; ?>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-slate-300 my-4 overflow-x-auto">
    <div class="p-6 text-gray-900">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        First name
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Last name
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Phone number
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Submit date
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-xs" x-data="{ open: false }">
                @foreach ($feedbackUsers as $feedbackUser)
                    <tr>
                        <td class="px-6 py-3 whitespace-nowrap">
                            {{ $feedbackUser->id }}
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            {{ $feedbackUser->first_name }}
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            {{ $feedbackUser->last_name }}
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            {{ $feedbackUser->phone_number }}
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            {{ $feedbackUser->submit_date }}
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap flex flex-row gap-2">
                            <button @click="open = true" class="bg-slate-100 border border-slate-300 rounded-lg p-2 text-slate-500 hover:bg-slate-200 hover:border-slate-400 hover:text-slate-600 transition-all duration-300">
                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5h8m-8 4h5m-5 6h8m-8 4h5M3 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1zm0 10a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
                            </button>

                            <!-- Pop-up -->
                            <div x-show="open" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" x-cloak>
                                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                    <div class="mt-3 text-center">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Dettagli Utente</h3>
                                        <div class="mt-2 px-7 py-3">
                                            <table class="w-full text-sm text-left text-gray-500 border border-slate-300">
                                                <tr>
                                                    <td class="font-bold bg-slate-200 p-2 border border-slate-300">Nome:</td>
                                                    <td class="bg-white p-2 border border-slate-300">{{ $feedbackUser->first_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold bg-slate-200 p-2 border border-slate-300">Cognome:</td>
                                                    <td class="bg-white p-2 border border-slate-300">{{ $feedbackUser->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold bg-slate-200 p-2 border border-slate-300">Telefono:</td>
                                                    <td class="bg-white p-2 border border-slate-300">{{ $feedbackUser->phone_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold bg-slate-200 p-2 border border-slate-300">Data di inizio:</td>
                                                    <td class="bg-white p-2 border border-slate-300">{{ $feedbackUser->start_date }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold bg-slate-200 p-2 border border-slate-300">Data di invio:</td>
                                                    <td class="bg-white p-2 border border-slate-300">{{ $feedbackUser->submit_date }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold bg-slate-200 p-2 border border-slate-300">Consenso 1:</td>
                                                    <td class="bg-white p-2 border border-slate-300">{{ $feedbackUser->first_consent ? 'Accettato' : 'Non accettato' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold bg-slate-200 p-2 border border-slate-300">Consenso 2:</td>
                                                    <td class="bg-white p-2 border border-slate-300">{{ $feedbackUser->second_consent ? 'Accettato' : 'Non accettato' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold bg-slate-200 p-2 border border-slate-300">Consenso 3:</td>
                                                    <td class="bg-white p-2 border border-slate-300">{{ $feedbackUser->third_consent ? 'Accettato' : 'Non accettato' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="items-center px-4 py-3">
                                            <button @click="open = false" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                                Chiudi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form id="download-pdf-form" wire:submit.prevent="downloadPdf({{ $feedbackUser }})">
                                <input type="hidden" name="feedbackUser" value="{{ $feedbackUser }}">
                            </form>
                            <button
                                class="bg-slate-100 border border-slate-300 rounded-lg p-2 text-slate-500 hover:bg-slate-200 hover:border-slate-400 hover:text-slate-600 transition-all duration-300"
                                type="submit" form="download-pdf-form">
                                <svg width="24" height="24" viewBox="0 0 32 32"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor"
                                        d="M24 24v4H8v-4H6v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4Z" />
                                    <path fill="currentColor"
                                        d="m21 21l-1.414-1.414L17 22.172V14h-2v8.172l-2.586-2.586L11 21l5 5zm7-17V2h-6v10h2V8h3V6h-3V4zm-11 8h-4V2h4a3.003 3.003 0 0 1 3 3v4a3.003 3.003 0 0 1-3 3m-2-2h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-2zM9 2H4v10h2V9h3a2.003 2.003 0 0 0 2-2V4a2 2 0 0 0-2-2M6 7V4h3l.001 3z" />
                                </svg>
                            </button>
                            <form id="delete-form" wire:submit.prevent="delete({{ $feedbackUser->id }})">
                                <input type="hidden" name="id" value="{{ $feedbackUser->id }}">
                            </form>
                            <button
                                class="bg-slate-100 border border-slate-300 rounded-lg p-2 text-red-400 hover:bg-slate-200 hover:border-slate-400 hover:text-red-500 transition-all duration-300"
                                type="submit" form="delete-form">
                                <svg width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5"
                                        d="m14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21q.512.078 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48 48 0 0 0-3.478-.397m-12 .562q.51-.088 1.022-.165m0 0a48 48 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a52 52 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a49 49 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            {{ $feedbackUsers->links() }}
        </table>
    </div>
</div>
