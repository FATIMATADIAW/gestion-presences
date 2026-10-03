@extends('layouts.app')

@section('title', 'Élèves')

@section('content')
    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Liste des élèves</h1>
        <a class="btn-add" href="{{ route('eleves.create') }}">
            <i class="bi bi-plus-lg"></i> Nouvel élève
        </a>
    </div>

    <form method="GET" action="{{ route('eleves.index') }}" class="mb-3">
        <div class="input-group" style="max-width: 400px;">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="recherche" value="{{ request('recherche') }}"
                   class="form-control" placeholder="Rechercher un élève...">
            @if(request('recherche'))
                <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Matricule</th>
                        <th>Classe</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($eleves as $eleve)
                        <tr>
                            <td>{{ $eleve->nom }}</td>
                            <td>{{ $eleve->prenom }}</td>
                            <td>{{ $eleve->matricule ?? '—' }}</td>
                            <td><span class="badge-classe">{{ $eleve->classe->nom ?? '—' }}</span></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('eleves.edit', $eleve) }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <form action="{{ route('eleves.destroy', $eleve) }}" method="POST"
                                          onsubmit="return confirm('Supprimer cet élève ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-supprimer btn-sm text-white">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">
                            @if(request('recherche'))
                                Aucun élève trouvé pour « {{ request('recherche') }} ».
                            @else
                                Aucun élève pour le moment.
                            @endif
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection