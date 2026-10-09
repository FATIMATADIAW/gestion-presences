<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Seance;
use Illuminate\Http\Request;

class EspaceEleveController extends Controller
{
    public function index(Request $request)
    {
        $eleve = Eleve::with('classe')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Statistiques (toujours sur l'ensemble des pointages, sans filtre)
        $total   = $eleve->presences()->count();
        $absents = $eleve->presences()->where('statut', 'absent')->count();
        $retards = $eleve->presences()->where('statut', 'retard')->count();
        $taux    = $total > 0 ? round((($total - $absents) / $total) * 100) : 0;

        // Filtres
        $statut = $request->query('statut');
        $ordre  = $request->query('ordre', 'recent') === 'ancien' ? 'asc' : 'desc';

        $presences = $eleve->presences()
            ->join('seances', 'seances.id', '=', 'presences.seance_id')
            ->select('presences.*')
            ->with('seance')
            ->when($statut === 'non_justifiee', function ($q) {
                $q->where('presences.statut', 'absent')
                  ->where('presences.justifiee', false);
            })
            ->when(in_array($statut, ['present', 'absent', 'retard'], true), function ($q) use ($statut) {
                $q->where('presences.statut', $statut);
            })
            ->when($request->filled('matiere'), function ($q) use ($request) {
                $q->where('seances.matiere', $request->query('matiere'));
            })
            ->orderBy('seances.date', $ordre)
            ->orderBy('seances.heure', $ordre)
            ->get();

        // Liste des matières pour le menu déroulant
        $matieres = Seance::whereIn('id', $eleve->presences()->pluck('seance_id'))
            ->whereNotNull('matiere')
            ->distinct()
            ->orderBy('matiere')
            ->pluck('matiere');

        return view('espace-eleve.index', compact(
            'eleve', 'total', 'taux', 'absents', 'retards', 'presences', 'matieres'
        ));
    }
}