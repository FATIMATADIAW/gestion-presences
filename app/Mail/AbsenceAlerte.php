<?php

namespace App\Mail;

use App\Models\Presence;
use Illuminate\Mail\Mailable;

class AbsenceAlerte extends Mailable
{
    public function __construct(public Presence $presence, public ?string $destinataire = null)
    {
    }

    public function build()
    {
        return $this->subject('Absence non justifiée de ' . $this->presence->eleve->prenom)
            ->view('emails.absence-alerte');
    }
}