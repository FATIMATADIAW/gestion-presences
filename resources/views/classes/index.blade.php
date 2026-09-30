@extends('layouts.app')

@section('title', 'Classes')

@section('content')
    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Liste des classes</h1>
        <a class="btn-add" href="{{ route('classes.create') }}">
            <i class="bi bi-plus-lg"></i> Nouvelle classe
        </a>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Niveau</th>
                        <th>Nombre d'élèves</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classes as $classe)
                        <tr>
                            <td>{{ $classe->nom }}</td>
                            <td>{{ $classe->niveau ?? '—' }}</td>
                            <td><span class="badge-classe">{{ $classe->eleves_count }}</span></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('classes.edit', $classe) }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <form action="{{ route('classes.destroy', $classe) }}" method="POST"
                                          onsubmit="return confirm('Supprimer cette classe ?')">
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
                        <tr><td colspan="4" class="text-center text-muted py-4">Aucune classe pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection