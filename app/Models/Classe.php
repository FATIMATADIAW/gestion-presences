<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classes';

    protected $fillable = ['nom', 'niveau'];

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
