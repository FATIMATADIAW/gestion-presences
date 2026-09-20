@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <a href="{{ route('eleves.index') }}">← Retour à la liste des élèves</a>

    <h1 class="mt-3 mb-4">Nouvel élève</h1>

    @if ($classes->isEmpty())
        <div class="alert alert-warning">
            Vous devez d'abord créer une classe avant d'ajouter un élève.
            <a href="{{ route('classes.create') }}">Créer une classe</a>
        </div>
    @else
    <form action="{{ route('eleves.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
            @error('nom') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
            @error('prenom') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Matricule</label>
            <input type="text" name="matricule" class="form-control" placeholder="Ex : E2024-001" required>
            @error('matricule') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Classe</label>
            <select name="classe_id" class="form-select" required>
                <option value="">-- Choisir une classe --</option>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
            @error('classe_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Ajouter l'élève</button>
    </form>
    @endif
</div>
@endsection
