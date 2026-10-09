<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEnseignant(): bool
    {
        return $this->role === 'enseignant';
    }

    public function isEleve(): bool
    {
        return $this->role === 'eleve';
    }

    public function seances()
    {
        return $this->hasMany(Seance::class, 'enseignant_id');
    }

    public function eleve()
    {
        return $this->hasOne(Eleve::class);
    }
}