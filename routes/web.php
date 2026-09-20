<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/presences', [PresenceController::class, 'index'])->name('presences.index');
Route::get('/presences/creer', [PresenceController::class, 'creer'])->name('presences.creer');
Route::post('/presences/creer', [PresenceController::class, 'creerEnregistrer'])->name('presences.creerEnregistrer');
Route::get('/presences/{seance}', [PresenceController::class, 'pointer'])->name('presences.pointer');
Route::post('/presences/{seance}', [PresenceController::class, 'enregistrer'])->name('presences.enregistrer');

Route::get('/classes', [ClasseController::class, 'index'])->name('classes.index');
Route::get('/classes/creer', [ClasseController::class, 'create'])->name('classes.create');
Route::post('/classes', [ClasseController::class, 'store'])->name('classes.store');
Route::delete('/classes/{classe}', [ClasseController::class, 'destroy'])->name('classes.destroy');

Route::get('/eleves', [EleveController::class, 'index'])->name('eleves.index');
Route::get('/eleves/creer', [EleveController::class, 'create'])->name('eleves.create');
Route::post('/eleves', [EleveController::class, 'store'])->name('eleves.store');
Route::delete('/eleves/{eleve}', [EleveController::class, 'destroy'])->name('eleves.destroy');