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

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="GET" action="{{ url('/espace-eleve') }}" class="d-flex flex-wrap gap-2 mb-3">
        <select name="statut" class="form-select" style="max-width:220px">
            <option value="">Tous les statuts</option>
            <option value="present" {{ request('statut') === 'present' ? 'selected' : '' }}>Présent</option>
            <option value="absent" {{ request('statut') === 'absent' ? 'selected' : '' }}>Absent</option>
            <option value="retard" {{ request('statut') === 'retard' ? 'selected' : '' }}>Retard</option>
            <option value="non_justifiee" {{ request('statut') === 'non_justifiee' ? 'selected' : '' }}>Absences non justifiées</option>
        </select>

        <select name="matiere" class="form-select" style="max-width:220px">
            <option value="">Toutes les matières</option>
            @foreach ($matieres as $m)
                <option value="{{ $m }}" {{ request('matiere') === $m ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
        </select>

        <select name="ordre" class="form-select" style="max-width:220px">
            <option value="recent" {{ request('ordre', 'recent') === 'recent' ? 'selected' : '' }}>Plus récentes d'abord</option>
            <option value="ancien" {{ request('ordre') === 'ancien' ? 'selected' : '' }}>Plus anciennes d'abord</option>
        </select>

        <button type="submit" class="btn btn-primary">Filtrer</button>
        <a href="{{ url('/espace-eleve') }}" class="btn btn-outline-secondary">Réinitialiser</a>
    </form>

    @if ($presences->isEmpty())
        <div class="alert alert-info">Aucune présence trouvée.</div>
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
                                <div class="small text-muted">
                                    À justifier avant le {{ $p->created_at->copy()->addHours(72)->format('d/m/Y H:i') }}
                                </div>
                                <details class="mt-1">
                                    <summary class="text-primary" style="cursor:pointer">Justifier cette absence</summary>
                                    <form method="POST" action="{{ route('espace-eleve.justifier', $p->id) }}" class="mt-2">
                                        @csrf
                                        <textarea name="motif" class="form-control mb-2" rows="2"
                                                  placeholder="Motif (maladie, rendez-vous médical...)" required minlength="5" maxlength="500"></textarea>
                                        <button type="submit" class="btn btn-sm btn-success">Envoyer</button>
                                    </form>
                                </details>
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