@extends('layouts.app')

@section('title', 'Modifier la séance')

@section('content')
    <a href="{{ route('classes.index') }}" class="back-link">
    <i class="bi bi-arrow-left"></i> Retour à la liste des classes
   </a>
    <div class="card shadow-sm mt-3">
        <div class="card-body p-4">
            <h1 class="h3 mb-4">Modifier la séance</h1>

            <form action="{{ route('presences.modifierEnregistrer', $seance) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" id="date" name="date"
                               value="{{ old('date', $seance->date->format('Y-m-d')) }}"
                               class="form-control @error('date') is-invalid @enderror">
                        @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="heure" class="form-label">Heure</label>
                        <input type="time" id="heure" name="heure"
                               value="{{ old('heure', \Carbon\Carbon::parse($seance->heure)->format('H:i')) }}"
                               class="form-control @error('heure') is-invalid @enderror">
                        @error('heure') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="matiere" class="form-label">Matière</label>
                    <input type="text" id="matiere" name="matiere"
                           value="{{ old('matiere', $seance->matiere) }}"
                           class="form-control @error('matiere') is-invalid @enderror">
                    @error('matiere') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="classe_id" class="form-label">Classe</label>
                    <select id="classe_id" name="classe_id" class="form-select @error('classe_id') is-invalid @enderror">
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}"
                                {{ old('classe_id', $seance->classe_id) == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('classe_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Enregistrer</button>
                <a href="{{ route('presences.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection