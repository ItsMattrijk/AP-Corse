<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PraticienController;
use Illuminate\Support\Facades\Route;

// Page de connexion
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées (nécessitent une authentification)
Route::middleware('auth.custom')->group(function () {
    
    // Redirection de la racine vers la liste des praticiens
    Route::get('/', function () {
        return redirect()->route('praticiens.index');
    });

    // Routes des praticiens
    Route::get('/praticiens', [PraticienController::class, 'index'])->name('praticiens.index');
    Route::get('/praticiens/{id}', [PraticienController::class, 'show'])->name('praticiens.show');
    Route::post('/praticiens/{id}/anciennete', [PraticienController::class, 'updateAnciennete'])->name('praticiens.update.anciennete');
    
    // Statistiques
    Route::get('/statistiques', [PraticienController::class, 'stats'])->name('praticiens.stats');
});