<?php

namespace App\Console\Commands;

use App\Services\AlerteAbsences;
use Illuminate\Console\Command;

class AlerterParentsAbsences extends Command
{
    protected $signature = 'absences:alerter-parents';

    protected $description = 'Envoie une alerte aux parents pour les absences non justifiées depuis plus de 72 h';

    public function handle(): int
    {
        $n = AlerteAbsences::envoyer();
        $this->info("$n absence(s) alertée(s).");

        return self::SUCCESS;
    }
}