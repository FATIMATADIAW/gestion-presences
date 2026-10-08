<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Presence;
use App\Models\Seance;
use App\Services\AlerteAbsences;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Classes
        $classes = [];
        foreach ([['1ere Année', 'Licence 1'], ['2eme Année', 'Licence 2'], ['3eme Année', 'Licence 3']] as [$nom, $niveau]) {
            $classes[] = Classe::firstOrCreate(['nom' => $nom], ['niveau' => $niveau]);
        }

        // 2. Élèves (le matricule est généré automatiquement)
        $noms = [
            ['Diop', 'Awa'], ['Ndiaye', 'Moussa'], ['Fall', 'Fatou'], ['Sow', 'Ibrahima'],
            ['Ba', 'Mariama'], ['Sarr', 'Cheikh'], ['Gueye', 'Aminata'], ['Diallo', 'Omar'],
            ['Sy', 'Khady'], ['Faye', 'Modou'], ['Thiam', 'Astou'], ['Cisse', 'Pape'],
        ];

        foreach ($noms as $i => [$nom, $prenom]) {
            Eleve::firstOrCreate(
                ['nom' => $nom, 'prenom' => $prenom],
                ['classe_id' => $classes[$i % 3]->id]
            );
        }

        // 3. Séances passées + pointages
        $matieres = ['Algo', 'Base de données', 'Réseaux'];

        foreach ($classes as $c => $classe) {
            foreach ([1, 3] as $k => $joursAvant) {
                $seance = Seance::firstOrCreate([
                    'classe_id' => $classe->id,
                    'matiere'   => $matieres[($c + $k) % 3],
                    'date'      => now()->subDays($joursAvant)->toDateString(),
                ], [
                    'heure' => '08:00:00',
                ]);

                foreach ($classe->eleves()->get() as $i => $eleve) {
                    $statut = match (($i + $k) % 4) {
                        0       => AlerteAbsences::STATUT_ABSENT,
                        1       => 'retard',
                        default => 'present',
                    };

                    Presence::firstOrCreate(
                        ['seance_id' => $seance->id, 'eleve_id' => $eleve->id],
                        ['statut' => $statut, 'justifiee' => false]
                    );
                }
            }
        }
    }
}
