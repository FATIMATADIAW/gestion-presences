<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EleveController extends Controller
{
    public function index(Request $request): View
    {
        $eleves = Eleve::with('classe')
            ->when($request->filled('recherche'), function ($query) use ($request) {
                $recherche = $request->input('recherche');
                $query->where(function ($q) use ($recherche) {
                    $q->where('nom', 'like', "%{$recherche}%")
                      ->orWhere('prenom', 'like', "%{$recherche}%")
                      ->orWhere('matricule', 'like', "%{$recherche}%");
                });
            })
            ->orderBy('nom')
            ->get();

        return view('eleves.index', ['eleves' => $eleves]);
    }

    public function create(): View
    {
        $classes = Classe::orderBy('nom')->get();
        return view('eleves.create', ['classes' => $classes]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule' => 'required|string|max:255|unique:eleves,matricule',
            'classe_id' => 'required|exists:classes,id',
        ]);

        Eleve::create($data);

        return redirect()->route('eleves.index')->with('success', 'Élève ajouté avec succès.');
    }

    public function edit(Eleve $eleve): View
    {
        $classes = Classe::orderBy('nom')->get();
        return view('eleves.modifier', ['eleve' => $eleve, 'classes' => $classes]);
    }

    public function update(Request $request, Eleve $eleve): RedirectResponse
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule' => ['required', 'string', 'max:255', Rule::unique('eleves', 'matricule')->ignore($eleve->id)],
            'classe_id' => 'required|exists:classes,id',
        ]);

        $eleve->update($data);

        return redirect()->route('eleves.index')->with('success', 'Élève modifié.');
    }

    public function destroy(Eleve $eleve): RedirectResponse
    {
        $eleve->delete();
        return redirect()->route('eleves.index')->with('success', 'Élève supprimé.');
    }
}