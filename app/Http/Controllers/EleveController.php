<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            'classe_id' => 'required|exists:classes,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $eleve = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['prenom'] . ' ' . $data['nom'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'eleve',
            ]);

            return Eleve::create([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'classe_id' => $data['classe_id'],
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('eleves.index')
            ->with('success', "Élève ajouté. Matricule : {$eleve->matricule}");
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
            'classe_id' => 'required|exists:classes,id',
        ]);

        $eleve->update($data);

        return redirect()->route('eleves.index')->with('success', 'Élève modifié.');
    }

    public function destroy(Eleve $eleve): RedirectResponse
    {
        DB::transaction(function () use ($eleve) {
            $user = $eleve->user;
            $eleve->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('eleves.index')->with('success', 'Élève supprimé.');
    }

    // Formulaire : créer l'accès d'un élève qui n'a pas encore de compte
    public function acces(Eleve $eleve): View|RedirectResponse
    {
        if ($eleve->user_id) {
            return redirect()->route('eleves.index')
                ->with('success', 'Cet élève a déjà un accès.');
        }

        return view('eleves.acces', ['eleve' => $eleve]);
    }

    // Enregistre le compte de connexion de l'élève
    public function creerAcces(Request $request, Eleve $eleve): RedirectResponse
    {
        if ($eleve->user_id) {
            return redirect()->route('eleves.index')
                ->with('success', 'Cet élève a déjà un accès.');
        }

        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        DB::transaction(function () use ($data, $eleve) {
            $user = User::create([
                'name' => $eleve->prenom . ' ' . $eleve->nom,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'eleve',
            ]);

            $eleve->update(['user_id' => $user->id]);
        });

        return redirect()->route('eleves.index')
            ->with('success', "Accès créé pour {$eleve->prenom} {$eleve->nom}.");
    }
}