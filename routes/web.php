<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportExcelController;

Route::get('/', fn() => view('auth.login'));

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::prefix('lead')->name('lead.')->group(function () {
        Route::get('/', [ImportExcelController::class, 'showLeads'])->name('show');
        Route::get('/import', [ImportExcelController::class, 'showImport'])->name('import');
        Route::post('/upload', [ImportExcelController::class, 'upload'])->name('upload');
        Route::get('/verify/{importLog}', [ImportExcelController::class, 'verify'])->name('verify');
        Route::get('/process/{importLog}', [ImportExcelController::class, 'processFile'])->name('process');
    });
});
