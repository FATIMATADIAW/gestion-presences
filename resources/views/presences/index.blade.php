@extends('layouts.app')

@section('title', 'Séances')

@section('content')
    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Liste des séances</h1>
        <a class="btn-add" href="{{ route('presences.creer') }}">
            <i class="bi bi-plus-lg"></i> Nouvelle séance
        </a>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-cards">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Matière</th>
                        <th>Classe</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($seances as $seance)
                        <tr>
                            <td>{{ $seance->date->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($seance->heure)->format('H:i') }}</td>
                            <td>{{ ucfirst($seance->matiere) }}</td>
                            <td><span class="badge-classe">{{ $seance->classe->nom ?? '—' }}</span></td>
                            <td class="text-end actions">
                                <div class="d-inline-flex flex-wrap gap-1">
                                    <a class="btn btn-pointer btn-sm text-white" href="{{ route('presences.pointer', $seance) }}">
                                        <i class="bi bi-check2-square"></i> Pointer
                                    </a>
                                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('presences.modifier', $seance) }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <form action="{{ route('presences.supprimer', $seance) }}" method="POST"
                                          onsubmit="return confirm('Supprimer cette séance et ses pointages ?')">
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
                        <tr><td colspan="5" data-label="" class="text-center text-muted py-4">Aucune séance pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection