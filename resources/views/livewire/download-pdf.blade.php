<?php

use Livewire\Volt\Component;
use App\Models\FeedbackUser;
use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component {
    public $type_form_token;

    public function downloadPdf() {
        $this->type_form_token = session()->get('type_form_token');
        $feedbackUser = FeedbackUser::where('type_form', $this->type_form_token)->first();
        if (!$feedbackUser) {
            return redirect('/consenso-testimonianze');
        }
        $feedbackUserArray = $feedbackUser->toArray();
        $pdf = Pdf::loadView('pdf.feedback-user', $feedbackUserArray);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $feedbackUserArray['first_name'] . '_' . $feedbackUserArray['last_name'] . '_' . date('d-m-Y', strtotime($feedbackUserArray['submit_date'])) . '_' . $feedbackUserArray['id'] . '.pdf');
    }

    public function newForm() {
        $this->type_form_token = session()->get('type_form_token');
        $feedbackUser = FeedbackUser::where('type_form', $this->type_form_token)->first();
        if (!$feedbackUser) {
            return redirect('/consenso-testimonianze');
        }
        $feedbackUser->delete();
        session()->forget(['type_form_token', 'form_status']);
        return redirect('/consenso-testimonianze');
    }
}; ?>
<section class="flex flex-col justify-center items-center gap-2">
    <button wire:click="downloadPdf"
        class="bg-slate-500 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition duration-300">
    Scarica il tuo consenso
    </button>
    <button wire:click="newForm" class="bg-slate-500 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition duration-300">
        Compila un nuovo modulo
    </button>
</section>
