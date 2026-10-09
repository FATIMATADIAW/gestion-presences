<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Presence;
use Illuminate\Http\Request;

class JustificationEleveController extends Controller
{
    public function store(Request $request, Presence $presence)
    {
        $eleve = Eleve::where('user_id', auth()->id())->firstOrFail();

        // L'élève ne peut justifier que ses propres absences
        abort_unless($presence->eleve_id === $eleve->id, 403);
        abort_unless($presence->statut === 'absent', 403);

        if ($presence->justifiee) {
            return back()->with('error', 'Cette absence est déjà justifiée.');
        }

        $data = $request->validate([
            'motif' => 'required|string|min:5|max:500',
        ]);

        $presence->update([
            'justifiee'    => true,
            'motif'        => $data['motif'],
            'justifiee_le' => now(),
        ]);

        return back()->with('success', 'Votre justification a été enregistrée.');
    }
}