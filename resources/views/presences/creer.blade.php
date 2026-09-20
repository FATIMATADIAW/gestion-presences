<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle séance - ScolPrésence</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button { background: #16a34a; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin-top: 20px; }
        a.retour { display: inline-block; margin-bottom: 15px; color: #2563eb; text-decoration: none; }
        .erreur { color: #dc2626; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
    <a class="retour" href="{{ route('presences.index') }}">&larr; Retour à la liste des séances</a>

    <h1>Nouvelle séance</h1>

    <form action="{{ route('presences.creerEnregistrer') }}" method="POST">
        @csrf

        <label>Date</label>
        <input type="date" name="date" value="{{ old('date') }}">
        @error('date') <div class="erreur">{{ $message }}</div> @enderror

        <label>Heure</label>
        <input type="time" name="heure" value="{{ old('heure') }}">
        @error('heure') <div class="erreur">{{ $message }}</div> @enderror

        <label>Matière</label>
        <input type="text" name="matiere" value="{{ old('matiere') }}" placeholder="Ex : Français">
        @error('matiere') <div class="erreur">{{ $message }}</div> @enderror

        <label>Classe</label>
        <select name="classe_id">
            <option value="">-- Choisir une classe --</option>
            @foreach($classes as $classe)
                <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                    {{ $classe->nom }}
                </option>
            @endforeach
        </select>
        @error('classe_id') <div class="erreur">{{ $message }}</div> @enderror

        <button type="submit">Créer la séance</button>
    </form>
</body>
</html>