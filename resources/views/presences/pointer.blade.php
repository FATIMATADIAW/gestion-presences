@extends('layouts.app')

@section('title', 'Pointage')

@section('content')
    <a class="back-link" href="{{ route('presences.index') }}">&larr; Retour à la liste des séances</a>

    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Pointage — {{ ucfirst($seance->matiere) }}</h1>
    </div>

    <div class="mb-3">
        <span class="meta-chip">📅 {{ $seance->date->format('d/m/Y') }}</span>
        <span class="meta-chip">🕒 {{ \Carbon\Carbon::parse($seance->heure)->format('H:i') }}</span>
        <span class="meta-chip">🏫 Classe : {{ $seance->classe->nom ?? '—' }}</span>
    </div>

    <form action="{{ route('presences.enregistrer', $seance) }}" method="POST">
        @csrf

        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eleves as $eleve)
                            @php
                                $statutActuel = $presences[$eleve->id] ?? 'present';
                            @endphp
                            <tr>
                                <td>{{ $eleve->nom }}</td>
                                <td>{{ $eleve->prenom }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="statuts[{{ $eleve->id }}]"
                                               id="present-{{ $eleve->id }}" value="present"
                                               {{ $statutActuel === 'present' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success btn-sm" for="present-{{ $eleve->id }}">Présent</label>

                                        <input type="radio" class="btn-check" name="statuts[{{ $eleve->id }}]"
                                               id="absent-{{ $eleve->id }}" value="absent"
                                               {{ $statutActuel === 'absent' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-danger btn-sm" for="absent-{{ $eleve->id }}">Absent</label>

                                        <input type="radio" class="btn-check" name="statuts[{{ $eleve->id }}]"
                                               id="retard-{{ $eleve->id }}" value="retard"
                                               {{ $statutActuel === 'retard' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning btn-sm" for="retard-{{ $eleve->id }}">Retard</label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-4">Aucun élève dans cette classe.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-add">Enregistrer les présences</button>
            <a class="btn-cancel" href="{{ route('presences.index') }}">Annuler</a>
        </div>
    </form>
@endsection