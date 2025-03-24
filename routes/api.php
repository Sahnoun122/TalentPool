<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AnnonceController;
use App\Http\Controllers\API\CandidatureController;

use App\Http\Controllers\API\StatistiqueController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('jwt.auth');

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::post('refresh', [AuthController::class, 'refresh']);


Route::middleware('jwt.auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('annonces', AnnonceController::class);

    Route::post('candidatures', [CandidatureController::class, 'store']);
    Route::delete('candidatures/{id}', [CandidatureController::class, 'destroy']);

    Route::get('annonces/{annonceId}/candidatures', [CandidatureController::class, 'index']);

    Route::put('candidatures/{id}/statut', [CandidatureController::class, 'modifierStatut']);


    Route::get('recruteurs/{recruteurId}/statistiques', [StatistiqueController::class, 'statistiquesAdmin']);

    Route::get('admin/statistiques', [StatistiqueController::class, 'statistiquesAdmin']);
});

