<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agence extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'nom',
        'adresse',
        'phone',
        'email',
    ];

    public function chauffeurs()
    {
        return $this->hasMany(Chauffeur::class);
    }
    public function voitures()
    {
        return $this->hasMany(Voiture::class);
    }
}
