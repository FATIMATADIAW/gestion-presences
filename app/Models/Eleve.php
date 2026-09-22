<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $table = 'eleves';

    protected $fillable = ['nom', 'prenom', 'matricule', 'date_naissance', 'classe_id'];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}