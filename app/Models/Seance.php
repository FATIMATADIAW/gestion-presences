<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $table = 'seances';

    protected $fillable = ['date', 'heure', 'matiere', 'classe_id', 'enseignant_id'];

    protected $casts = [
        'date' => 'date',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}