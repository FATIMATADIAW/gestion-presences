<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    // Liste des séances (pour choisir laquelle pointer)
    public function index()
    {
        $seances = Seance::with('classe')->orderBy('date', 'desc')->get();
        return view('presences.index', compact('seances'));
    }

    // Formulaire de pointage pour une séance donnée
    public function pointer(Seance $seance)
    {
        $eleves = $seance->classe->eleves()->orderBy('nom')->get();

        // Récupère les présences déjà enregistrées pour cette séance (s'il y en a)
        $presences = Presence::where('seance_id', $seance->id)
            ->pluck('statut', 'eleve_id');

        return view('presences.pointer', compact('seance', 'eleves', 'presences'));
    }

    // Enregistrement des présences
    public function enregistrer(Request $request, Seance $seance)
    {
        $request->validate([
            'statuts' => 'required|array',
            'statuts.*' => 'in:present,absent,retard',
        ]);

        foreach ($request->statuts as $eleveId => $statut) {
            Presence::updateOrCreate(
                ['seance_id' => $seance->id, 'eleve_id' => $eleveId],
                ['statut' => $statut]
            );
        }

        return redirect()->route('presences.index')
            ->with('success', 'Présences enregistrées pour la séance du ' . $seance->date->format('d/m/Y'));
    }

    // Formulaire de création d'une séance
    public function creer()
    {
        $classes = \App\Models\Classe::orderBy('nom')->get();
        return view('presences.creer', compact('classes'));
    }

    // Enregistrement de la nouvelle séance
    public function creerEnregistrer(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'heure' => 'required',
            'matiere' => 'required|string|max:50',
            'classe_id' => 'required|exists:classes,id',
        ]);

        Seance::create([
            'date' => $request->date,
            'heure' => $request->heure,
            'matiere' => $request->matiere,
            'classe_id' => $request->classe_id,
            'enseignant_id' => 1, // temporaire, en attendant le système de connexion
        ]);

        return redirect()->route('presences.index')
            ->with('success', 'Nouvelle séance créée avec succès.');
    }
}