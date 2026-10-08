@extends('layouts.app')

@section('title', 'Nouveau professeur')

@section('content')
    <a class="back-link" href="{{ route('professeurs.index') }}">← Retour à la liste des professeurs</a>

    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Nouveau professeur</h1>
    </div>

    <div class="form-card mt-3">
        <form action="{{ route('professeurs.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nom complet</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-add">Créer le professeur</button>
                <a class="btn-cancel" href="{{ route('professeurs.index') }}">Annuler</a>
            </div>
        </form>
    </div>
@endsection