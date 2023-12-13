<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'titre',
        'description',
        'date_debut',
        'date_fin',
        'voiture_id',
        'chauffeur_id'
    ];

    public function voitures()
    {
        return $this->belongsToMany(Voiture::class);
    }

    public function chauffeurs()
{
    return $this->belongsToMany(Chauffeur::class, 'mission_chauffeur', 'mission_id', 'chauffeur_id');
}
}
