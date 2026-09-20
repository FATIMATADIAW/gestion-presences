<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Pointage - ScolPrésence</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        .statuts label { margin-right: 12px; cursor: pointer; }
        button { background: #16a34a; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin-top: 20px; }
        a.retour { display: inline-block; margin-bottom: 15px; color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
    <a class="retour" href="{{ route('presences.index') }}">&larr; Retour à la liste des séances</a>

    <h1>Pointage — {{ $seance->matiere }}</h1>
    <p>{{ $seance->date->format('d/m/Y') }} à {{ $seance->heure }} — Classe : {{ $seance->classe->nom ?? '—' }}</p>

    <form action="{{ route('presences.enregistrer', $seance) }}" method="POST">
        @csrf
        <table>
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
                        <td class="statuts">
                            <label>
                                <input type="radio" name="statuts[{{ $eleve->id }}]" value="present" {{ $statutActuel === 'present' ? 'checked' : '' }}>
                                Présent
                            </label>
                            <label>
                                <input type="radio" name="statuts[{{ $eleve->id }}]" value="absent" {{ $statutActuel === 'absent' ? 'checked' : '' }}>
                                Absent
                            </label>
                            <label>
                                <input type="radio" name="statuts[{{ $eleve->id }}]" value="retard" {{ $statutActuel === 'retard' ? 'checked' : '' }}>
                                Retard
                            </label>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">Aucun élève dans cette classe.</td></tr>
                @endforelse
            </tbody>
        </table>

        <button type="submit">Enregistrer les présences</button>
    </form>
</body>
</html>




