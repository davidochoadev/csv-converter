<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'home']);
Route::get('/download-pdf', function () {
    if (session()->has('pdf_content') && session()->has('pdf_filename')) {
        $content = base64_decode(session('pdf_content'));
        $filename = session('pdf_filename');

        session()->forget(['pdf_content', 'pdf_filename']);

        return response($content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    return redirect('/');
})->name('download.pdf');
Route::view('/consenso-testimonianze', 'consenso-testimonianze');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('pdf/feedback-user', 'pdf.feedback-user')
    ->middleware(['auth'])
    ->name('pdf.feedback-user');

Route::post('csv/upload', [CsvController::class, 'upload'])->name('csv.upload');

require __DIR__.'/auth.php';
