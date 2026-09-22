@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">Statistiques d'absentéisme</h1>

    <!-- Cartes chiffrées -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h6 class="text-muted">Total pointages</h6>
                    <h2>{{ $totalPresences }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h6 class="text-muted">Taux de présence</h6>
                    <h2 class="text-success">{{ $tauxPresence }}%</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <h6 class="text-muted">Taux d'absentéisme</h6>
                    <h2 class="text-danger">{{ $tauxAbsenteisme }}%</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <h6 class="text-muted">Retards</h6>
                    <h2 class="text-warning">{{ $totalRetard }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Répartition globale -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Répartition globale</h5>
            <div class="progress" style="height: 30px;">
                @php
                    $pctPresent = $totalPresences > 0 ? ($totalPresent / $totalPresences) * 100 : 0;
                    $pctAbsent = $totalPresences > 0 ? ($totalAbsent / $totalPresences) * 100 : 0;
                    $pctRetard = $totalPresences > 0 ? ($totalRetard / $totalPresences) * 100 : 0;
                @endphp
                <div class="progress-bar bg-success" style="width: {{ $pctPresent }}%">
                    Présent ({{ $totalPresent }})
                </div>
                <div class="progress-bar bg-danger" style="width: {{ $pctAbsent }}%">
                    Absent ({{ $totalAbsent }})
                </div>
                <div class="progress-bar bg-warning" style="width: {{ $pctRetard }}%">
                    Retard ({{ $totalRetard }})
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Taux d'absentéisme par classe -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Absentéisme par classe</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Classe</th>
                                <th>Absences</th>
                                <th>Taux</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classes as $classe)
                            <tr>
                                <td>{{ $classe['nom'] }}</td>
                                <td>{{ $classe['total_absences'] }} / {{ $classe['total_pointages'] }}</td>
                                <td>
                                    <span class="badge {{ $classe['taux_absenteisme'] > 20 ? 'bg-danger' : 'bg-secondary' }}">
                                        {{ $classe['taux_absenteisme'] }}%
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3">Aucune donnée disponible.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top 5 élèves les plus absents -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Élèves les plus absents</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Élève</th>
                                <th>Classe</th>
                                <th>Absences</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($elevesAbsences as $eleve)
                            <tr>
                                <td>{{ $eleve['nom_complet'] }}</td>
                                <td>{{ $eleve['classe'] }}</td>
                                <td><span class="badge bg-danger">{{ $eleve['absences'] }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3">Aucune absence enregistrée.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
