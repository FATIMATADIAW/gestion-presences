<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Séances - ScolPrésence</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        a.btn { background: #2563eb; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; }
        .success { background: #d1fae5; color: #065f46; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>Liste des séances</h1>
    <p><a class="btn" href="{{ route('presences.creer') }}">+ Nouvelle séance</a></p>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Matière</th>
                <th>Classe</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seances as $seance)
                <tr>
                    <td>{{ $seance->date->format('d/m/Y') }}</td>
                    <td>{{ $seance->heure }}</td>
                    <td>{{ $seance->matiere }}</td>
                    <td>{{ $seance->classe->nom ?? '—' }}</td>
                    <td><a class="btn" href="{{ route('presences.pointer', $seance) }}">Pointer</a></td>
                </tr>
            @empty
                <tr><td colspan="5">Aucune séance pour le moment.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>