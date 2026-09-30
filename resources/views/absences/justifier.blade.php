@extends('layouts.app')

@section('title', "Justifier l'absence")

@section('content')
<a href="{{ route('absences.index') }}" class="back-link">← Retour à la liste des absences</a>

<div class="form-card">
    <h1 class="page-title mb-2"><span class="bar"></span> Justifier l'absence</h1>
    <p class="mb-4">
        <span class="meta-chip">{{ $presence->eleve->prenom }} {{ $presence->eleve->nom }}</span>
        <span class="meta-chip">{{ $presence->seance->matiere }}</span>
        <span class="meta-chip">{{ $presence->seance->date->format('d/m/Y') }}</span>
    </p>

    <form method="POST" action="{{ route('absences.justifier.enregistrer', $presence->id) }}">
        @csrf

        <div class="mb-3">
            <label for="motif" class="form-label">Motif</label>
            <select id="motif" name="motif" required class="form-select @error('motif') is-invalid @enderror">
                <option value="">-- Choisir --</option>
                @foreach(['Maladie', 'Rendez-vous médical', 'Transport', 'Raison familiale', 'Autre'] as $m)
                    <option value="{{ $m }}" @selected(old('motif') === $m)>{{ $m }}</option>
                @endforeach
            </select>
            @error('motif') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="commentaire" class="form-label">Commentaire</label>
            <textarea id="commentaire" name="commentaire" rows="4" class="form-control">{{ old('commentaire') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-add">Enregistrer</button>
            <a href="{{ route('absences.index') }}" class="btn-cancel">Annuler</a>
        </div>
    </form>
</div>
@endsection