<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClasseController extends Controller
{
    public function index(): View
    {
        $classes = Classe::withCount('eleves')->orderBy('nom')->get();
        return view('classes.index', ['classes' => $classes]);
    }

    public function create(): View
    {
        return view('classes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:255',
        ]);

        Classe::create($data);

        return redirect()->route('classes.index')->with('success', 'Classe créée avec succès.');
    }

    public function edit(Classe $classe): View
    {
        return view('classes.modifier', ['classe' => $classe]);
    }

    public function update(Request $request, Classe $classe): RedirectResponse
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:255',
        ]);

        $classe->update($data);

        return redirect()->route('classes.index')->with('success', 'Classe modifiée.');
    }

    public function destroy(Classe $classe): RedirectResponse
    {
        $classe->delete();
        return redirect()->route('classes.index')->with('success', 'Classe supprimée.');
    }
}