<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\ProfesseurController;

Route::get('/', function () {
    return view('welcome');
});

// Connexion / Inscription / Déconnexion
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // ENSEIGNANT : séances, appel, justification
    Route::middleware('role:enseignant')->group(function () {
        Route::get('/presences', [PresenceController::class, 'index'])->name('presences.index');
        Route::get('/presences/creer', [PresenceController::class, 'creer'])->name('presences.creer');
        Route::post('/presences/creer', [PresenceController::class, 'creerEnregistrer'])->name('presences.creerEnregistrer');
        Route::get('/presences/{seance}/modifier', [PresenceController::class, 'modifier'])->name('presences.modifier');
        Route::put('/presences/{seance}', [PresenceController::class, 'modifierEnregistrer'])->name('presences.modifierEnregistrer');
        Route::get('/presences/{seance}', [PresenceController::class, 'pointer'])->name('presences.pointer');
        Route::post('/presences/{seance}', [PresenceController::class, 'enregistrer'])->name('presences.enregistrer');
        Route::delete('/presences/{seance}', [PresenceController::class, 'supprimer'])->name('presences.supprimer');

        Route::post('/absences/alertes', [AbsenceController::class, 'envoyerAlertes'])->name('absences.alertes');
        Route::get('/absences/{id}/justifier', [AbsenceController::class, 'justifier'])->name('absences.justifier');
        Route::post('/absences/{id}/justifier', [AbsenceController::class, 'enregistrer'])->name('absences.justifier.enregistrer');
        Route::get('/absences/{id}/alerter', [AbsenceController::class, 'alerter'])->name('absences.alerter');
        Route::post('/absences/{id}/alerter', [AbsenceController::class, 'envoyerAlerte'])->name('absences.alerter.envoyer');
    });

    // ADMIN : gestion et consultation, jamais d'appel
    Route::middleware('role:admin')->group(function () {
        Route::get('/classes', [ClasseController::class, 'index'])->name('classes.index');
        Route::get('/classes/creer', [ClasseController::class, 'create'])->name('classes.create');
        Route::post('/classes', [ClasseController::class, 'store'])->name('classes.store');
        Route::get('/classes/{classe}/modifier', [ClasseController::class, 'edit'])->name('classes.edit');
        Route::put('/classes/{classe}', [ClasseController::class, 'update'])->name('classes.update');
        Route::delete('/classes/{classe}', [ClasseController::class, 'destroy'])->name('classes.destroy');

        Route::get('/eleves', [EleveController::class, 'index'])->name('eleves.index');
        Route::get('/eleves/creer', [EleveController::class, 'create'])->name('eleves.create');
        Route::post('/eleves', [EleveController::class, 'store'])->name('eleves.store');
        Route::get('/eleves/{eleve}/modifier', [EleveController::class, 'edit'])->name('eleves.edit');
        Route::put('/eleves/{eleve}', [EleveController::class, 'update'])->name('eleves.update');
        Route::delete('/eleves/{eleve}', [EleveController::class, 'destroy'])->name('eleves.destroy');

        Route::get('/professeurs', [ProfesseurController::class, 'index'])->name('professeurs.index');
        Route::get('/professeurs/creer', [ProfesseurController::class, 'create'])->name('professeurs.create');
        Route::post('/professeurs', [ProfesseurController::class, 'store'])->name('professeurs.store');
        Route::delete('/professeurs/{user}', [ProfesseurController::class, 'destroy'])->name('professeurs.destroy');

        Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');
    });

    // Liste des absences : admin ET enseignant
    Route::get('/absences', [AbsenceController::class, 'index'])
        ->middleware('role:admin,enseignant')
        ->name('absences.index');
});                 