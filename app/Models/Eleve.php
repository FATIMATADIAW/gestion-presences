<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $table = 'eleves';

    protected $fillable = [
        'nom', 'prenom', 'matricule', 'date_naissance', 'classe_id',
        'parent_nom', 'parent_email', 'parent_telephone',
        'pere_nom', 'pere_email', 'mere_nom', 'mere_email',
        'user_id',
    ];

    protected static function booted()
    {
        static::creating(function ($eleve) {
            $eleve->matricule = static::genererMatricule();
        });
    }

    // Génère E2026-001, E2026-002, etc.
    public static function genererMatricule(): string
    {
        $annee = now()->year;

        $dernierNumero = static::where('matricule', 'like', "E{$annee}-%")
            ->pluck('matricule')
            ->map(fn ($m) => (int) substr($m, strrpos($m, '-') + 1))
            ->max() ?? 0;

        return sprintf('E%d-%03d', $annee, $dernierNumero + 1);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}