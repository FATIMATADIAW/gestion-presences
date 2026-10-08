<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Presence;
use App\Models\Classe;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /**
     * L'admin accède à toutes les séances ;
     * un enseignant uniquement aux siennes.
     */
    private function autoriser(Seance $seance): void
    {
        $user = auth()->user();

        abort_unless(
            $user->isAdmin() || (int) $seance->enseignant_id === (int) $user->id,
            403,
            "Cette séance appartient à un autre enseignant."
        );
    }

    // Liste des séances
    public function index()
    {
        $seances = Seance::with('classe')
            ->when(!auth()->user()->isAdmin(), fn ($q) => $q->where('enseignant_id', auth()->id()))
            ->orderBy('date', 'desc')
            ->get();

        return view('presences.index', compact('seances'));
    }

    // Formulaire de pointage
    public function pointer(Seance $seance)
    {
        $this->autoriser($seance);

        $eleves = $seance->classe->eleves()->orderBy('nom')->get();

        $presences = Presence::where('seance_id', $seance->id)
            ->pluck('statut', 'eleve_id');

        return view('presences.pointer', compact('seance', 'eleves', 'presences'));
    }

    // Enregistrement des présences
    public function enregistrer(Request $request, Seance $seance)
    {
        $this->autoriser($seance);

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
        $classes = Classe::orderBy('nom')->get();
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
            'enseignant_id' => auth()->id(),
        ]);

        return redirect()->route('presences.index')
            ->with('success', 'Nouvelle séance créée avec succès.');
    }

    // Modifier une séance
    public function modifier(Seance $seance)
    {
        $this->autoriser($seance);

        $classes = Classe::orderBy('nom')->get();
        return view('presences.modifier', compact('seance', 'classes'));
    }

    public function modifierEnregistrer(Request $request, Seance $seance)
    {
        $this->autoriser($seance);

        $data = $request->validate([
            'date'      => 'required|date',
            'heure'     => 'required',
            'matiere'   => 'required|string|max:50',
            'classe_id' => 'required|exists:classes,id',
        ]);

        $seance->update($data);

        return redirect()->route('presences.index')->with('success', 'Séance modifiée.');
    }

    // Suppression d'une séance (et de ses pointages)
    public function supprimer(Seance $seance)
    {
        $this->autoriser($seance);

        Presence::where('seance_id', $seance->id)->delete();
        $seance->delete();

        return redirect()->route('presences.index')
            ->with('success', 'Séance supprimée.');
    }
}