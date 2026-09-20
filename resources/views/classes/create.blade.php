@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <a href="{{ route('classes.index') }}">← Retour à la liste des classes</a>

    <h1 class="mt-3 mb-4">Nouvelle classe</h1>

    <form action="{{ route('classes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom de la classe</label>
            <input type="text" name="nom" class="form-control" placeholder="Ex : 6ème A" required>
            @error('nom') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Niveau (optionnel)</label>
            <input type="text" name="niveau" class="form-control" placeholder="Ex : Collège">
        </div>

        <button type="submit" class="btn btn-success">Créer la classe</button>
    </form>
</div>
@endsection
