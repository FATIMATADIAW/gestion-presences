@extends('layouts.app')

@section('title', "Modifier l'élève")

@section('content')
    <a href="{{ route('eleves.index') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Retour à la liste des élèves
    </a>

    <div class="card shadow-sm mt-3">
        <div class="card-body p-4">
            <h1 class="h3 mb-4">Modifier l'élève</h1>

            <form action="{{ route('eleves.update', $eleve) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom', $eleve->nom) }}"
                               class="form-control @error('nom') is-invalid @enderror">
                        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $eleve->prenom) }}"
                               class="form-control @error('prenom') is-invalid @enderror">
                        @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Matricule</label>
                    <input type="text" value="{{ $eleve->matricule }}" class="form-control" readonly disabled>
                </div>

                <div class="mb-4">
                    <label for="classe_id" class="form-label">Classe</label>
                    <select id="classe_id" name="classe_id" class="form-select @error('classe_id') is-invalid @enderror">
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}"
                                {{ old('classe_id', $eleve->classe_id) == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('classe_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Enregistrer</button>
                <button type="button"
                        class="btn btn-outline-secondary"
                        onclick="window.location.href='{{ route('eleves.index') }}'">
                    Annuler
                </button>
            </form>
        </div>
    </div>
@endsection