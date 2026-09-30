<?php

namespace App\Services;

use App\Mail\AbsenceAlerte;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AlerteAbsences
{
    // Valeur de la colonne "statut" pour une absence : à changer ici si besoin
    public const STATUT_ABSENT = 'absent';
    public const DELAI_HEURES = 48;

    public static function debutSeance(Presence $p): Carbon
    {
        $date = $p->seance->date->copy()->startOfDay();
        try {
            if ($p->seance->heure) {
                return Carbon::parse($date->format('Y-m-d') . ' ' . $p->seance->heure);
            }
        } catch (\Throwable $e) {
        }
        return $date;
    }

    public static function heuresEcoulees(Presence $p): int
    {
        return (int) self::debutSeance($p)->diffInHours(now(), false);
    }

    // justifiee | alerte | depasse | attente
    public static function statut(Presence $p): string
    {
        if ($p->justifiee) return 'justifiee';
        if ($p->alerte_envoyee_le) return 'alerte';
        if (self::heuresEcoulees($p) >= self::DELAI_HEURES) return 'depasse';
        return 'attente';
    }

    public static function envoyer(): int
    {
        $absences = Presence::with(['eleve', 'seance'])
            ->where('statut', self::STATUT_ABSENT)
            ->where('justifiee', false)
            ->whereNull('alerte_envoyee_le')
            ->get();

        $envoyees = 0;

        foreach ($absences as $p) {
            if (!$p->seance || !$p->eleve || !$p->eleve->parent_email) continue;
            if (self::heuresEcoulees($p) < self::DELAI_HEURES) continue;

            Mail::to($p->eleve->parent_email)->send(new AbsenceAlerte($p));
            $p->update(['alerte_envoyee_le' => now()]);
            $envoyees++;
        }

        return $envoyees;
    }
}