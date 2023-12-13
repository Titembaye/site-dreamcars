<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voiture extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'immatriculation',
        'marque',
        'modele',
        'puissance',
        'capacite',
        'annee',
        'montant_journalier',
        'image',
        'status'
    ];

    public function markAsReserved()
    {
        $this->update(['status' => 'Reserved']);
    }

    public function markAsAvailable()
    {
        $this->update(['status' => 'Available']);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function count_voiture_reservation()
    {
        return Reservation::where('voiture_id', $this->id)->count();
    }
    
    public function disponibilite()
    {
        return $this->hasOne(DisponibiliteVehicule::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
    public function missions()
    {
        return $this->belongsToMany(Mission::class);
    }
  
}
