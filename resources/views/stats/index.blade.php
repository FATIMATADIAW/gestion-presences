@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
    <style>
        .filter-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 1.2rem 1.5rem;
            margin: 1rem 0 1.5rem;
        }
        .filter-card .form-label { font-weight: 600; font-size: 0.85rem; }
        .filter-card .form-control,
        .filter-card .form-select { border-radius: 8px; padding: 0.6rem 0.9rem; }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        @media (max-width: 992px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
        .stat-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 1.2rem 1.4rem;
            border-left: 5px solid var(--primary);
        }
        .stat-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .stat-value { font-size: 2.3rem; font-weight: 800; line-height: 1.25; }
        .stat-present { border-left-color: var(--primary); }
        .stat-present .stat-value { color: var(--primary); }
        .stat-absent { border-left-color: var(--danger); }
        .stat-absent .stat-value { color: var(--danger); }
        .stat-retard { border-left-color: var(--accent); }
        .stat-retard .stat-value { color: var(--accent-dark); }

        .chart-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 1.3rem 1.5rem;
            height: 100%;
        }
        .chart-card h2 { font-size: 1.05rem; font-weight: 700; margin-bottom: 1rem; }

        .card-head {
            padding: 1.1rem 1.5rem;
            font-weight: 700;
            font-size: 1.05rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .badge-taux {
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
            color: #fff;
        }
        .taux-ok { background: var(--primary); }
        .taux-warn { background: var(--accent); color: var(--on-accent); }
        .taux-high { background: var(--danger); }

        .empty-note {
            background: #fff7e6;
            border-left: 5px solid var(--accent);
            border-radius: 10px;
            padding: 1rem 1.3rem;
            margin-bottom: 1.5rem;
        }
        .empty-note a { color: var(--primary); font-weight: 600; }
    </style>

    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Statistiques d'assiduité</h1>
    </div>

    {{-- Filtres --}}
    <form method="GET" action="{{ route('stats.index') }}" class="filter-card">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Classe</label>
                <select name="classe_id" class="form-select">
                    <option value="">Toutes les classes</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Du</label>
                <input type="date" name="du" value="{{ $du }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Au</label>
                <input type="date" name="au" value="{{ $au }}" class="form-control">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn-add w-100" type="submit">Filtrer</button>
                <a href="{{ route('stats.index') }}" class="btn-cancel" title="Réinitialiser">✕</a>
            </div>
        </div>
    </form>

    {{-- Cartes --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-label">Total pointages</div>
            <div class="stat-value">{{ $total }}</div>
        </div>
        <div class="stat-card stat-present">
            <div class="stat-label">Taux de présence</div>
            <div class="stat-value">{{ $tauxPresence }}%</div>
        </div>
        <div class="stat-card stat-absent">
            <div class="stat-label">Taux d'absentéisme</div>
            <div class="stat-value">{{ $tauxAbsence }}%</div>
        </div>
        <div class="stat-card stat-retard">
            <div class="stat-label">Retards</div>
            <div class="stat-value">{{ $retards }}</div>
        </div>
    </div>

    @if($total === 0)
        <div class="empty-note">
            Aucun pointage pour ces critères. Allez dans <a href="{{ route('presences.index') }}">Séances</a>,
            cliquez sur <strong>Pointer</strong> puis enregistrez les présences.
        </div>
    @endif

    {{-- Graphiques --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-5">
            <div class="chart-card">
                <h2>Répartition globale</h2>
                <div style="height:280px"><canvas id="chartRepartition"></canvas></div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="chart-card">
                <h2>Taux d'absentéisme par classe (%)</h2>
                <div style="height:280px"><canvas id="chartClasses"></canvas></div>
            </div>
        </div>
    </div>

    {{-- Tableaux --}}
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="table-card h-100">
                <div class="card-head">Absentéisme par classe</div>
                <table class="table align-middle mb-0">
                    <thead>
                        <tr><th>Classe</th><th>Absences</th><th>Taux</th></tr>
                    </thead>
                    <tbody>
                        @forelse($parClasse as $r)
                            <tr>
                                <td>{{ $r->nom }}</td>
                                <td>{{ $r->absents }} / {{ $r->total }}</td>
                                <td>
                                    <span class="badge-taux {{ $r->taux_absence >= 20 ? 'taux-high' : ($r->taux_absence >= 10 ? 'taux-warn' : 'taux-ok') }}">
                                        {{ $r->taux_absence }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-muted text-center py-4">Aucune donnée.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="table-card h-100">
                <div class="card-head">Élèves les plus absents</div>
                <table class="table align-middle mb-0">
                    <thead>
                        <tr><th>Élève</th><th>Classe</th><th>Absences</th></tr>
                    </thead>
                    <tbody>
                        @forelse($topAbsents as $e)
                            <tr>
                                <td>{{ $e->nom }} {{ $e->prenom }}</td>
                                <td><span class="badge-classe">{{ $e->classe }}</span></td>
                                <td><span class="badge-taux taux-high">{{ $e->absences }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-muted text-center py-4">Aucune absence enregistrée.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    const vert = '#1f7a5f', rouge = '#e53935', orange = '#f5a623';

    new Chart(document.getElementById('chartRepartition'), {
        type: 'doughnut',
        data: {
            labels: ['Présents', 'Absents', 'Retards'],
            datasets: [{
                data: [{{ $presents }}, {{ $absents }}, {{ $retards }}],
                backgroundColor: [vert, rouge, orange],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: { legend: { position: 'bottom' } }
        }
    });

    const nomsClasses = @json($parClasse->pluck('nom'));
    const tauxClasses = @json($parClasse->pluck('taux_absence'));

    new Chart(document.getElementById('chartClasses'), {
        type: 'bar',
        data: {
            labels: nomsClasses,
            datasets: [{
                label: "Taux d'absentéisme (%)",
                data: tauxClasses,
                backgroundColor: tauxClasses.map(t => t >= 20 ? rouge : (t >= 10 ? orange : vert)),
                borderRadius: 8,
                maxBarThickness: 70
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, max: 100 } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush