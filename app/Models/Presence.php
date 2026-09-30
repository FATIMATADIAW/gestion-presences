<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $table = 'presences';

    protected $fillable = [
        'statut',
        'seance_id',
        'eleve_id',
        'justifiee',
        'motif',
        'commentaire',
        'justifiee_le',
        'alerte_envoyee_le',
    ];

    protected $casts = [
        'justifiee' => 'boolean',
        'justifiee_le' => 'datetime',
        'alerte_envoyee_le' => 'datetime',
    ];

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}