@extends('layouts.app')

@section('title', 'Modifier la classe')

@section('content')
    <a href="{{ route('classes.index') }}" class="back-link">← Retour à la liste des classes</a>

    <div class="card shadow-sm mt-3">
        <div class="card-body p-4">
            <h1 class="h3 mb-4">Modifier la classe</h1>

            <form action="{{ route('classes.update', $classe) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de la classe</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $classe->nom) }}"
                           class="form-control @error('nom') is-invalid @enderror">
                    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="niveau" class="form-label">Niveau (optionnel)</label>
                    <input type="text" id="niveau" name="niveau" value="{{ old('niveau', $classe->niveau) }}"
                           class="form-control @error('niveau') is-invalid @enderror">
                    @error('niveau') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-add">Enregistrer</button>
                    <a href="{{ route('classes.index') }}" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection