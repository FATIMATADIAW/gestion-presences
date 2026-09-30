<p>Bonjour {{ $destinataire ?: $presence->eleve->parent_nom }},</p>

<p>
    Nous vous informons que <strong>{{ $presence->eleve->prenom }} {{ $presence->eleve->nom }}</strong>
    était absent(e) à la séance de <strong>{{ $presence->seance->matiere }}</strong>
    du {{ $presence->seance->date->format('d/m/Y') }}.
</p>

<p>Cette absence n'a pas été justifiée. Merci de contacter l'établissement.</p>

<p>Cordialement,<br>L'administration</p>