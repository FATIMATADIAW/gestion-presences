<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Presence;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $classeId = $request->query('classe_id');
        $du = $request->query('du');
        $au = $request->query('au');

        $base = Presence::query()
            ->join('seances', 'presences.seance_id', '=', 'seances.id')
            ->join('eleves', 'presences.eleve_id', '=', 'eleves.id')
            ->when($classeId, fn ($q) => $q->where('seances.classe_id', $classeId))
            ->when($du, fn ($q) => $q->whereDate('seances.date', '>=', $du))
            ->when($au, fn ($q) => $q->whereDate('seances.date', '<=', $au));

        $c = (clone $base)->selectRaw("
            COUNT(*) as total,
            SUM(presences.statut = 'present') as presents,
            SUM(presences.statut = 'absent') as absents,
            SUM(presences.statut = 'retard') as retards
        ")->first();

        $total   = (int) $c->total;
        $presents = (int) $c->presents;
        $absents  = (int) $c->absents;
        $retards  = (int) $c->retards;

        $tauxPresence = $total ? round(($presents + $retards) / $total * 100) : 0;
        $tauxAbsence  = $total ? round($absents / $total * 100) : 0;

        $parClasse = (clone $base)
            ->join('classes', 'seances.classe_id', '=', 'classes.id')
            ->selectRaw("classes.nom as nom, COUNT(*) as total,
                SUM(presences.statut = 'absent') as absents,
                SUM(presences.statut = 'retard') as retards")
            ->groupBy('classes.id', 'classes.nom')
            ->get()
            ->map(function ($r) {
                $r->taux_absence = $r->total ? round($r->absents / $r->total * 100) : 0;
                $r->taux_presence = 100 - $r->taux_absence;
                return $r;
            });

        $topAbsents = (clone $base)
            ->join('classes', 'eleves.classe_id', '=', 'classes.id')
            ->where('presences.statut', 'absent')
            ->selectRaw('eleves.nom, eleves.prenom, classes.nom as classe, COUNT(*) as absences')
            ->groupBy('eleves.id', 'eleves.nom', 'eleves.prenom', 'classes.nom')
            ->orderByDesc('absences')
            ->limit(5)
            ->get();

        $classes = Classe::orderBy('nom')->get();

        return view('stats.index', compact(
            'total', 'presents', 'absents', 'retards',
            'tauxPresence', 'tauxAbsence',
            'parClasse', 'topAbsents', 'classes',
            'classeId', 'du', 'au'
        ));
    }
}