<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesseurController extends Controller
{
    public function index()
    {
        $professeurs = User::where('role', 'enseignant')
            ->withCount('seances')
            ->orderBy('name')
            ->get();

        return view('professeurs.index', compact('professeurs'));
    }

    public function create()
    {
        return view('professeurs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique'       => 'Cette adresse e-mail a déjà un compte.',
            'password.min'       => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'Les deux mots de passe ne correspondent pas.',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'enseignant',
        ]);

        return redirect()->route('professeurs.index')->with('success', 'Professeur ajouté.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'enseignant') {
            abort(403);
        }

        if ($user->seances()->exists()) {
            return back()->with('error', 'Ce professeur a des séances enregistrées : suppression impossible.');
        }

        $user->delete();

        return back()->with('success', 'Professeur supprimé.');
    }
}