<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🔐 dashboard sécurisé
Route::get('/dashboard', [TransactionController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔐 toutes les routes protégées
Route::middleware('auth')->group(function () {

    // 👤 profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // rapports
    Route::get('/rapports', [TransactionController::class, 'rapports']);
    

    // Alertes 
    Route::get('/alertes', [TransactionController::class, 'alertes']);


    Route::view('/apropos', 'apropos');
    Route::view('/aide', 'aide');

    // 💰 transactions
    Route::get('/ajouter', [TransactionController::class, 'create']);
    Route::post('/ajouter', [TransactionController::class, 'store']);

    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
    Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit']);
    Route::put('/transactions/{id}', [TransactionController::class, 'update']);

    // 💳 dettes
    Route::get('/dettes', [DetteController::class, 'index']);
    Route::get('/dettes/create', [DetteController::class, 'create']);
    Route::post('/dettes/store', [DetteController::class, 'store']);
    Route::get('/dettes/payer/{id}', [DetteController::class, 'payer']);
    Route::post('/dettes/paiement/{id}', [DetteController::class, 'paiementPartiel']);
});

// 🔐 routes auth (login, register...)
require __DIR__.'/auth.php';