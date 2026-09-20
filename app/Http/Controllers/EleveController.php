<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EleveController extends Controller
{
    public function index(): View
    {
        $eleves = Eleve::with('classe')->orderBy('nom')->get();
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

    public function destroy(Eleve $eleve): RedirectResponse
    {
        $eleve->delete();
        return redirect()->route('eleves.index')->with('success', 'Élève supprimé.');
    }
}
