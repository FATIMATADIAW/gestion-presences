<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Presence;
use Illuminate\View\View;

class StatsController extends Controller
{
    public function index(): View
    {
        // --- Chiffres globaux ---
        $totalPresences = Presence::count();
        $totalPresent = Presence::where('statut', 'present')->count();
        $totalAbsent = Presence::where('statut', 'absent')->count();
        $totalRetard = Presence::where('statut', 'retard')->count();

        $tauxAbsenteisme = $totalPresences > 0
            ? round(($totalAbsent / $totalPresences) * 100, 1)
            : 0;

        $tauxPresence = $totalPresences > 0
            ? round(($totalPresent / $totalPresences) * 100, 1)
            : 0;

        // --- Taux d'absentéisme par classe ---
        $classes = Classe::with('eleves.presences')->get()->map(function ($classe) {
            $totalPointages = 0;
            $totalAbsences = 0;

            foreach ($classe->eleves as $eleve) {
                foreach ($eleve->presences as $presence) {
                    $totalPointages++;
                    if ($presence->statut === 'absent') {
                        $totalAbsences++;
                    }
                }
            }

            $taux = $totalPointages > 0 ? round(($totalAbsences / $totalPointages) * 100, 1) : 0;

            return [
                'nom' => $classe->nom,
                'total_pointages' => $totalPointages,
                'total_absences' => $totalAbsences,
                'taux_absenteisme' => $taux,
            ];
        });

        // --- Top 5 élèves les plus absents ---
        $elevesAbsences = Eleve::with('classe')->get()->map(function ($eleve) {
            $absences = $eleve->presences()->where('statut', 'absent')->count();
            $totalPointages = $eleve->presences()->count();

            return [
                'nom_complet' => $eleve->nom_complet,
                'classe' => $eleve->classe->nom ?? '—',
                'absences' => $absences,
                'total_pointages' => $totalPointages,
            ];
        })->filter(fn ($e) => $e['absences'] > 0)
          ->sortByDesc('absences')
          ->take(5)
          ->values();

        return view('stats.index', [
            'totalPresences' => $totalPresences,
            'totalPresent' => $totalPresent,
            'totalAbsent' => $totalAbsent,
            'totalRetard' => $totalRetard,
            'tauxAbsenteisme' => $tauxAbsenteisme,
            'tauxPresence' => $tauxPresence,
            'classes' => $classes,
            'elevesAbsences' => $elevesAbsences,
        ]);
    }
}
