<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class EspaceEleveController extends Controller
{
    // Valeurs de la colonne "statut" dans la table presences
    private const PRESENT = 'present';
    private const ABSENT = 'absent';
    private const RETARD = 'retard';

    public function index(): View
    {
        $eleve = auth()->user()->eleve;

        abort_if(!$eleve, 403, "Aucun profil élève n'est associé à ce compte.");

        $eleve->load('classe');

        $presences = $eleve->presences()
            ->with('seance')
            ->get()
            ->sortByDesc(fn ($p) => optional($p->seance)->date);

        $total = $presences->count();
        $absents = $presences->where('statut', self::ABSENT)->count();
        $retards = $presences->where('statut', self::RETARD)->count();
        $presents = $presences->where('statut', self::PRESENT)->count();
        $taux = $total > 0 ? round((($total - $absents) / $total) * 100) : 0;

        return view('espace-eleve.index', [
            'eleve' => $eleve,
            'presences' => $presences,
            'total' => $total,
            'presents' => $presents,
            'absents' => $absents,
            'retards' => $retards,
            'taux' => $taux,
        ]);
    }
}