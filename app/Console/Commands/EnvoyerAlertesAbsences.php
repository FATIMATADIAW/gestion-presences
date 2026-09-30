<?php

namespace App\Console\Commands;

use App\Services\AlerteAbsences;
use Illuminate\Console\Command;

class EnvoyerAlertesAbsences extends Command
{
    protected $signature = 'absences:alerter';
    protected $description = 'Envoie un email aux parents pour les absences non justifiées depuis 48 h';

    public function handle(): int
    {
        $n = AlerteAbsences::envoyer();
        $this->info("$n alerte(s) envoyée(s).");
        return self::SUCCESS;
    }
}