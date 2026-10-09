@extends('layouts.app')

@section('title', 'Accès élève')

@section('content')
    <a href="{{ route('eleves.index') }}" class="back-link">← Retour à la liste des élèves</a>

    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Créer l'accès de {{ $eleve->prenom }} {{ $eleve->nom }}</h1>
    </div>

    <div class="form-card">
        <p class="text-muted">Matricule : {{ $eleve->matricule }}</p>

        <form action="{{ route('eleves.acces.creer', $eleve) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email de connexion</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe provisoire</label>
                <input type="text" name="password" class="form-control" required minlength="8">
                <small class="text-muted">8 caractères minimum. À communiquer à l'élève.</small>
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-add">Créer l'accès</button>
                <a href="{{ route('eleves.index') }}" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
@endsection