<?php

namespace App\Http\Controllers;

use App\Mail\AbsenceAlerte;
use App\Models\Presence;
use App\Services\AlerteAbsences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Presence::with(['eleve.classe', 'seance'])
            ->where('statut', AlerteAbsences::STATUT_ABSENT)
            ->orderByDesc('id')
            ->get();

        return view('absences.index', compact('absences'));
    }

    public function envoyerAlertes()
    {
        $n = AlerteAbsences::envoyer();
        return redirect()->route('absences.index')->with('success', "$n alerte(s) envoyée(s).");
    }

    public function justifier($id)
    {
        $presence = Presence::with(['eleve', 'seance'])->findOrFail($id);
        return view('absences.justifier', compact('presence'));
    }

    public function enregistrer(Request $request, $id)
    {
        $data = $request->validate([
            'motif' => 'required|string|max:255',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        Presence::findOrFail($id)->update([
            'justifiee' => true,
            'motif' => $data['motif'],
            'commentaire' => $data['commentaire'] ?? null,
            'justifiee_le' => now(),
        ]);

        return redirect()->route('absences.index')->with('success', 'Absence justifiée.');
    }

    public function alerter($id)
    {
        $presence = Presence::with(['eleve.classe', 'seance'])->findOrFail($id);
        $contacts = $this->contacts($presence->eleve);

        return view('absences.alerter', compact('presence', 'contacts'));
    }

    public function envoyerAlerte(Request $request, $id)
    {
        $presence = Presence::with(['eleve', 'seance'])->findOrFail($id);
        $contacts = $this->contacts($presence->eleve);

        $data = $request->validate([
            'destinataires' => 'required|array|min:1',
            'destinataires.*' => 'in:pere,mere,tuteur',
        ], [
            'destinataires.required' => 'Choisis au moins un parent.',
        ]);

        $n = 0;
        foreach ($data['destinataires'] as $cle) {
            if (isset($contacts[$cle])) {
                Mail::to($contacts[$cle]['email'])
                    ->send(new AbsenceAlerte($presence, $contacts[$cle]['nom']));
                $n++;
            }
        }

        if ($n > 0) {
            $presence->update(['alerte_envoyee_le' => now()]);
        }

        return redirect()->route('absences.index')->with('success', "$n alerte(s) envoyée(s).");
    }

    // Contacts de l'élève qui ont un email
    private function contacts($eleve): array
    {
        $definitions = [
            'pere'   => ['Père',   'pere_nom',   'pere_email'],
            'mere'   => ['Mère',   'mere_nom',   'mere_email'],
            'tuteur' => ['Tuteur', 'parent_nom', 'parent_email'],
        ];

        $liste = [];
        foreach ($definitions as $cle => [$lien, $champNom, $champEmail]) {
            if ($eleve->$champEmail) {
                $liste[$cle] = [
                    'lien' => $lien,
                    'nom' => $eleve->$champNom,
                    'email' => $eleve->$champEmail,
                ];
            }
        }

        return $liste;
    }
}