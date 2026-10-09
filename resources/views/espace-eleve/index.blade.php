@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h1 class="mb-1">Bonjour {{ $eleve->prenom }} {{ $eleve->nom }}</h1>
    <p class="text-muted mb-4">
        Matricule : {{ $eleve->matricule }}
        @if ($eleve->classe) · Classe : {{ $eleve->classe->nom }} @endif
    </p>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card p-3">
                <small class="text-muted">Total pointages</small>
                <h3>{{ $total }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card p-3">
                <small class="text-muted">Taux de présence</small>
                <h3 class="text-success">{{ $taux }}%</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card p-3">
                <small class="text-muted">Absences</small>
                <h3 class="text-danger">{{ $absents }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card p-3">
                <small class="text-muted">Retards</small>
                <h3 class="text-warning">{{ $retards }}</h3>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Mes présences</h4>

    @if ($presences->isEmpty())
        <div class="alert alert-info">Aucune présence enregistrée pour le moment.</div>
    @else
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Matière</th>
                    <th>Statut</th>
                    <th>Justification</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presences as $p)
                <tr>
                    <td>{{ optional($p->seance)->date ? $p->seance->date->format('d/m/Y') : '-' }}</td>
                    <td>{{ optional($p->seance)->heure ? substr($p->seance->heure, 0, 5) : '-' }}</td>
                    <td>{{ optional($p->seance)->matiere ?? '-' }}</td>
                    <td>
                        @if ($p->statut === 'present')
                            <span class="badge bg-success">Présent</span>
                        @elseif ($p->statut === 'absent')
                            <span class="badge bg-danger">Absent</span>
                        @elseif ($p->statut === 'retard')
                            <span class="badge bg-warning text-dark">Retard</span>
                        @else
                            <span class="badge bg-secondary">{{ $p->statut }}</span>
                        @endif
                    </td>
                    <td>
                        @if ($p->statut === 'absent')
                            @if ($p->justifiee)
                                <span class="text-success">Justifiée</span>
                                @if ($p->motif) · {{ $p->motif }} @endif
                            @else
                                <span class="text-danger">Non justifiée</span>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection