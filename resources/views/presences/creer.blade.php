@extends('layouts.app')

@section('title', 'Nouvelle séance')

@section('content')
    <a class="back-link" href="{{ route('presences.index') }}">&larr; Retour à la liste des séances</a>

    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Nouvelle séance</h1>
    </div>

    <div class="form-card mt-3">
        <form action="{{ route('presences.creerEnregistrer') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" id="date" name="date" value="{{ old('date') }}"
                       class="form-control @error('date') is-invalid @enderror">
                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="heure" class="form-label">Heure</label>
                <input type="time" id="heure" name="heure" value="{{ old('heure') }}"
                       class="form-control @error('heure') is-invalid @enderror">
                @error('heure') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="matiere" class="form-label">Matière</label>
                <input type="text" id="matiere" name="matiere" value="{{ old('matiere') }}"
                       placeholder="Ex : Français"
                       class="form-control @error('matiere') is-invalid @enderror">
                @error('matiere') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="classe_id" class="form-label">Classe</label>
                <select id="classe_id" name="classe_id"
                        class="form-select @error('classe_id') is-invalid @enderror">
                    <option value="">-- Choisir une classe --</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
                @error('classe_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-add">Créer la séance</button>
                <a class="btn-cancel" href="{{ route('presences.index') }}">Annuler</a>
            </div>
        </form>
    </div>
@endsection