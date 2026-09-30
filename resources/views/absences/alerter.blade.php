@extends('layouts.app')

@section('title', 'Alerter un parent')

@section('content')
<a href="{{ route('absences.index') }}" class="back-link">← Retour aux absences</a>

<div class="page-header">
    <h1 class="page-title"><span class="bar"></span> Alerter un parent</h1>
</div>

<p style="margin-bottom:1rem;">
    <span class="meta-chip">{{ $presence->eleve->prenom }} {{ $presence->eleve->nom }}</span>
    <span class="meta-chip">{{ $presence->eleve->classe->nom ?? '-' }}</span>
    <span class="meta-chip">{{ $presence->seance->matiere }} · {{ $presence->seance->date->format('d/m/Y') }}</span>
</p>

<div class="form-card">
    @if(count($contacts) === 0)
        <p>Aucun email de parent n'est enregistré pour cet élève.</p>
        <a href="{{ route('eleves.edit', $presence->eleve->id) }}" class="btn-add">Modifier l'élève</a>
    @else
        <form method="POST" action="{{ route('absences.alerter.envoyer', $presence->id) }}">
            @csrf

            <label class="form-label">Qui doit recevoir l'alerte ?</label>

            @foreach($contacts as $cle => $c)
                <div class="form-check" style="margin-bottom:0.6rem;">
                    <input class="form-check-input" type="checkbox" name="destinataires[]"
                           value="{{ $cle }}" id="dest-{{ $cle }}">
                    <label class="form-check-label" for="dest-{{ $cle }}">
                        <strong>{{ $c['lien'] }}</strong>
                        @if($c['nom']) · {{ $c['nom'] }} @endif
                        <span style="color:#6b7280;">({{ $c['email'] }})</span>
                    </label>
                </div>
            @endforeach

            @error('destinataires')
                <div style="color:var(--danger); margin-top:0.5rem;">{{ $message }}</div>
            @enderror

            <div class="form-actions">
                <button type="submit" class="btn-add">Envoyer l'alerte</button>
                <a href="{{ route('absences.index') }}" class="btn-cancel">Annuler</a>
            </div>
        </form>
    @endif
</div>
@endsection