@extends('layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
    <h2>Absences</h2>
    <form method="POST" action="{{ route('absences.alertes') }}">
        @csrf
        <button type="submit" style="background:var(--accent); color:var(--on-accent); border:0; padding:10px 16px; border-radius:8px; cursor:pointer; font-weight:600;">
            Envoyer les alertes maintenant
        </button>
    </form>
</div>

@if(session('success'))
    <div style="background:#e6f4ea; padding:10px 14px; border-radius:8px; margin-bottom:12px;">{{ session('success') }}</div>
@endif

<table style="width:100%; border-collapse:collapse; background:#fff;">
    <thead>
        <tr style="background:var(--primary); color:#fff; text-align:left;">
            <th style="padding:10px;">Élève</th>
            <th style="padding:10px;">Classe</th>
            <th style="padding:10px;">Séance</th>
            <th style="padding:10px;">Statut</th>
            <th style="padding:10px;">Action</th>
        </tr>
    </thead>
    <tbody>
    @forelse($absences as $a)
        @php
            $st = \App\Services\AlerteAbsences::statut($a);
            $reste = \App\Services\AlerteAbsences::DELAI_HEURES - \App\Services\AlerteAbsences::heuresEcoulees($a);
        @endphp
        <tr style="border-bottom:1px solid #e5e7eb;">
            <td style="padding:10px;">{{ $a->eleve->prenom }} {{ $a->eleve->nom }}</td>
            <td style="padding:10px;">{{ $a->eleve->classe->nom ?? '-' }}</td>
            <td style="padding:10px;">{{ $a->seance->matiere }} · {{ $a->seance->date->format('d/m/Y') }}</td>
            <td style="padding:10px;">
                @if($st === 'justifiee') Justifiée ({{ $a->motif }})
                @elseif($st === 'alerte') Parent alerté
                @elseif($st === 'depasse') Délai dépassé
                @else Non justifiée (alerte dans {{ max($reste, 0) }} h)
                @endif
            </td>
            <td style="padding:10px;">
                @if($st !== 'justifiee')
                    <div style="display:inline-flex; gap:6px;">
                        <button type="button"
                                style="background:var(--accent); color:var(--on-accent); border:0; padding:6px 12px; border-radius:8px; cursor:pointer; font-weight:600;"
                                onclick="window.location.href='{{ route('absences.alerter', $a->id) }}'">
                            Alerter
                        </button>
                        <button type="button"
                                style="background:var(--primary); color:#fff; border:0; padding:6px 12px; border-radius:8px; cursor:pointer; font-weight:600;"
                                onclick="window.location.href='{{ route('absences.justifier', $a->id) }}'">
                            Justifier
                        </button>
                    </div>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="5" style="padding:16px; text-align:center;">Aucune absence.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection