<?php

namespace App\Services;

use App\Mail\AbsenceAlerte;
use App\Models\Eleve;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AlerteAbsences
{
    // Valeur de la colonne "statut" pour une absence : à changer ici si besoin
    public const STATUT_ABSENT = 'absent';
    public const DELAI_HEURES = 72;

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

    // Père, mère et tuteur ayant un e-mail (sans doublon si la même adresse est saisie deux fois)
    public static function destinataires(Eleve $eleve): array
    {
        $definitions = [
            ['pere_nom',   'pere_email'],
            ['mere_nom',   'mere_email'],
            ['parent_nom', 'parent_email'],
        ];

        $liste = [];
        foreach ($definitions as [$champNom, $champEmail]) {
            $email = trim((string) $eleve->$champEmail);
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }
            $liste[strtolower($email)] = [
                'email' => $email,
                'nom'   => $eleve->$champNom,
            ];
        }

        return array_values($liste);
    }

    // Retourne le nombre d'absences pour lesquelles une alerte a été envoyée
    public static function envoyer(): int
    {
        $absences = Presence::with(['eleve', 'seance'])
            ->where('statut', self::STATUT_ABSENT)
            ->where('justifiee', false)
            ->whereNull('alerte_envoyee_le')
            ->get();

        $envoyees = 0;

        foreach ($absences as $p) {
            if (!$p->seance || !$p->eleve) continue;
            if (self::heuresEcoulees($p) < self::DELAI_HEURES) continue;

            $destinataires = self::destinataires($p->eleve);
            if (empty($destinataires)) continue;

            $envoye = false;
            foreach ($destinataires as $d) {
                try {
                    Mail::to($d['email'])->send(new AbsenceAlerte($p, $d['nom']));
                    $envoye = true;
                } catch (\Throwable $e) {
                    // Un échec d'envoi ne bloque pas les autres parents
                    report($e);
                }
            }

            // Marquée seulement si au moins un e-mail est parti : sinon nouvel essai au prochain passage
            if ($envoye) {
                $p->update(['alerte_envoyee_le' => now()]);
                $envoyees++;
            }
        }

        return $envoyees;
    }
}