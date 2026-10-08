<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = [
        'date',
        'heure',
        'matiere',
        'classe_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function pointages()
    {
        return $this->hasMany(Pointage::class);
    }
}