<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'voiture_id',
        'date_debut',
        'heure_depart',
        'lieu_depart',
        'date_fin',
        'heure_fin',
        'destination',
        'montant_reservation',
        'montant_total',
        'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }
}
