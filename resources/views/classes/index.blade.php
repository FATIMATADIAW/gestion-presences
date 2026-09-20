@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h1 class="mb-3">Liste des classes</h1>

    <a href="{{ route('classes.create') }}" class="btn btn-primary mb-3">+ Nouvelle classe</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Niveau</th>
                <th>Nombre d'élèves</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($classes as $classe)
            <tr>
                <td>{{ $classe->nom }}</td>
                <td>{{ $classe->niveau ?? '—' }}</td>
                <td>{{ $classe->eleves_count }}</td>
                <td>
                    <form action="{{ route('classes.destroy', $classe) }}" method="POST"
                          onsubmit="return confirm('Supprimer cette classe ?');" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4">Aucune classe pour le moment.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
