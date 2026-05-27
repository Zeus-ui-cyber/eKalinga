<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Authentication Portal Entry point
Route::get('/', function () {
    return view('login');
})->name('login');


/*
|--------------------------------------------------------------------------
| Protected Clinical Environment (Requires User Authentication Session)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // 1. Core Dynamic Workspace Engine
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Clinician Workspace Actions
    Route::get('/patients/{id}', function ($id) {
        return "Displaying clinical history profile chart for Patient File REF: #" . e($id);
    })->name('patients.show');

    Route::get('/notes/{id}/edit', function ($id) {
        return "Opening secure documentation terminal for Clinical Note: #" . e($id);
    })->name('notes.edit');

    // 3. Coordinator Intake Pipeline Actions
    Route::get('/intake/{id}/process', function ($id) {
        return "Processing mental health screening intake submission protocol: #" . e($id);
    })->name('intake.process');

    // 4. Infrastructure System Administrator Actions
    Route::get('/audit-logs', function () {
        return "Decrypting secure master database transaction ledger logs...";
    })->name('audit.logs');

});