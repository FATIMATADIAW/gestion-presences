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
        $user = auth()->user();

        $absences = Presence::with(['eleve.classe', 'seance'])
            ->where('statut', AlerteAbsences::STATUT_ABSENT)
            ->when(!$user->isAdmin(), function ($q) use ($user) {
                $q->whereHas('seance', fn ($s) => $s->where('enseignant_id', $user->id));
            })
            ->orderByDesc('id')
            ->get();

        return view('absences.index', compact('absences'));
    }

    public function envoyerAlertes()
    {
        $n = AlerteAbsences::envoyer();
        return redirect()->route('absences.index')->with('success', "$n alerte(s) envoyée(s).");
    }

    // Un enseignant ne peut agir que sur les absences de ses propres séances
    private function presencePermise($id, array $relations)
    {
        $presence = Presence::with($relations)->findOrFail($id);

        $seance = $presence->seance;
        if (!$seance || $seance->enseignant_id !== auth()->id()) {
            abort(403, 'Cette absence ne concerne pas l\'une de vos séances.');
        }

        return $presence;
    }

    public function justifier($id)
    {
        $presence = $this->presencePermise($id, ['eleve', 'seance']);
        return view('absences.justifier', compact('presence'));
    }

    public function enregistrer(Request $request, $id)
    {
        $presence = $this->presencePermise($id, ['seance']);

        $data = $request->validate([
            'motif' => 'required|string|max:255',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $presence->update([
            'justifiee' => true,
            'motif' => $data['motif'],
            'commentaire' => $data['commentaire'] ?? null,
            'justifiee_le' => now(),
        ]);

        return redirect()->route('absences.index')->with('success', 'Absence justifiée.');
    }

    public function alerter($id)
    {
        $presence = $this->presencePermise($id, ['eleve.classe', 'seance']);
        $contacts = $this->contacts($presence->eleve);

        return view('absences.alerter', compact('presence', 'contacts'));
    }

    public function envoyerAlerte(Request $request, $id)
    {
        $presence = $this->presencePermise($id, ['eleve', 'seance']);
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