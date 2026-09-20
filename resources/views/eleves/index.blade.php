@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h1 class="mb-3">Liste des élèves</h1>

    <a href="{{ route('eleves.create') }}" class="btn btn-primary mb-3">+ Nouvel élève</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Matricule</th>
                <th>Classe</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($eleves as $eleve)
            <tr>
                <td>{{ $eleve->nom }}</td>
                <td>{{ $eleve->prenom }}</td>
                <td>{{ $eleve->matricule }}</td>
                <td>{{ $eleve->classe->nom ?? '—' }}</td>
                <td>
                    <form action="{{ route('eleves.destroy', $eleve) }}" method="POST"
                          onsubmit="return confirm('Supprimer cet élève ?');" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">Aucun élève pour le moment.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
