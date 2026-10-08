@extends('layouts.app')

@section('title', 'Absences')

@section('content')
    @php $estAdmin = auth()->user()->isAdmin(); @endphp

    <div class="page-header">
        <h1 class="page-title"><span class="bar"></span> Liste des absences</h1>
        @unless($estAdmin)
            <form action="{{ route('absences.alertes') }}" method="POST"
                  onsubmit="return confirm('Envoyer les alertes aux parents ?')">
                @csrf
                <button type="submit" class="btn-add">Envoyer les alertes</button>
            </form>
        @endunless
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
                        <th>Élève</th>
                        <th>Classe</th>
                        <th>Séance</th>
                        <th>Statut</th>
                        @unless($estAdmin)
                            <th class="text-end">Actions</th>
                        @endunless
                    </tr>
                </thead>
                <tbody>
                    @forelse($absences as $absence)
                        <tr>
                            <td>{{ $absence->eleve->nom ?? '—' }} {{ $absence->eleve->prenom ?? '' }}</td>
                            <td><span class="badge-classe">{{ $absence->eleve->classe->nom ?? '—' }}</span></td>
                            <td>
                                @if($absence->seance)
                                    {{ $absence->seance->date->format('d/m/Y') }} · {{ ucfirst($absence->seance->matiere) }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                @if($absence->justifiee)
                                    <span class="badge bg-success">Justifiée</span>
                                    <div class="small text-muted">{{ $absence->motif }}</div>
                                @else
                                    <span class="badge bg-danger">Non justifiée</span>
                                @endif
                                @if($absence->alerte_envoyee_le)
                                    <div class="small text-muted">Parents alertés</div>
                                @endif
                            </td>
                            @unless($estAdmin)
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        @unless($absence->justifiee)
                                            <a class="btn btn-pointer btn-sm text-white" href="{{ route('absences.justifier', $absence->id) }}">Justifier</a>
                                        @endunless
                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('absences.alerter', $absence->id) }}">Alerter</a>
                                    </div>
                                </td>
                            @endunless
                        </tr>
                    @empty
                        <tr><td colspan="{{ $estAdmin ? 4 : 5 }}" class="text-center text-muted py-4">Aucune absence pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection