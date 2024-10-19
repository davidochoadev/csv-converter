<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\FeedbackUser;

class CsvController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $path = $file->store('csv_files', 'public');

            // Leggi il contenuto del file CSV
            $csvContent = file_get_contents($file->getRealPath());
            $rows = array_map('str_getcsv', explode("\n", $csvContent));

            // Rimuovi eventuali righe vuote
            $rows = array_filter($rows);
            Log::info($rows);
            $type_form = $rows[1][0];
            Log::info($type_form);
            // Crea un nuovo FeedbackUser
            FeedbackUser::create([
                'first_name' => $rows[1][1],
                'last_name' => $rows[1][2],
                'phone_number' => ltrim($rows[1][3], "'"),
                'first_consent' => (bool)$rows[1][4],
                'second_consent' => (bool)$rows[1][5],
                'third_consent' => (bool)$rows[1][6],
                'response_type' => $rows[1][7],
                'start_date' => $rows[1][8],
                'submit_date' => $rows[1][10],
                'stage_date' => $rows[1][9],
                'network_id' => $rows[1][11],
                'type_form' => $type_form,
            ]);

            return back()->with('success', 'File CSV caricato e letto con successo');
        }

        // Aggiungi un log per il caso di errore
        Log::warning('Tentativo di caricamento CSV fallito: nessun file caricato');

        return back()->with('error', 'Nessun file caricato');
    }
}
