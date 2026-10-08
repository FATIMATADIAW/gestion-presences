<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Admin -> statistiques, enseignant -> séances
            $accueil = Auth::user()->isAdmin()
                ? route('stats.index')
                : route('presences.index');

            return redirect()->intended($accueil)->with('success', 'Connexion réussie.');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
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

        // Le rôle est imposé côté serveur : personne ne peut se créer un compte admin
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'enseignant',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/presences')->with('success', 'Compte créé. Bienvenue sur ScolPrésence !');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Vous avez été déconnecté.');
    }
}