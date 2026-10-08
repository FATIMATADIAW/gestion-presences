@extends('layouts.app')

@section('title', 'Professeurs')

@section('content')
    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Liste des professeurs</h1>
        <a class="btn-add" href="{{ route('professeurs.create') }}">Nouveau professeur</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <div class="table-card mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>E-mail</th>
                        <th>Séances</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($professeurs as $prof)
                        <tr>
                            <td>{{ $prof->name }}</td>
                            <td>{{ $prof->email }}</td>
                            <td><span class="badge-classe">{{ $prof->seances_count }}</span></td>
                            <td class="text-end">
                                <form action="{{ route('professeurs.destroy', $prof) }}" method="POST"
                                      onsubmit="return confirm('Supprimer ce professeur ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-supprimer btn-sm text-white">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Aucun professeur pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection