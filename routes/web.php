<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CandidatureController;
use App\Http\Controllers\API\StatistiqueController;

// Route::get('/', function () {
//     return response()->json(['message' => 'Welcome to the API']);
// });

Route::get('/register', [App\Http\Controllers\authViews::class, 'register'])->name('register');
Route::get('/connecter', [App\Http\Controllers\authViews::class, 'connecter'])->name('connecter');
Route::get('/resetpassword', [App\Http\Controllers\authViews::class, 'resetpassword'])->name('resetpassword');





Route::prefix('candidatures')->group(function () {
    Route::post('/', [CandidatureController::class, 'store'])
        ->name('candidatures.store');
    
    Route::get('/', [CandidatureController::class, 'index'])
        ->name('candidatures.index');
    
    Route::delete('/{id}', [CandidatureController::class, 'destroy'])
        ->name('candidatures.destroy');
    
    Route::put('/{id}/statut', [CandidatureController::class, 'modifierStatut'])
        ->name('candidatures.modifierStatut');
});

Route::prefix('statistiques')->group(function () {
    Route::get('/admin', [StatistiqueController::class, 'statistiquesAdmin'])
        ->name('statistiques.admin');
});

Route::middleware('auth:sanctum')->group(function () {
    
});