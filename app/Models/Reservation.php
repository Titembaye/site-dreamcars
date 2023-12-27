<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;
    //protected $primaryKey = 'reservation_id';
    //public $incrementing = false;
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'reservation_id',
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
    //relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //relation avec le modèle Voiture
    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }
    //relation avec le modèle Facture

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

    //methode pour generer la reservation_id
    public static function generateReservationId()
    {

        $prefix = 'R';
        $suffix = substr(md5(uniqid(rand(), true)), 0, 4); // Utilisez une partie du hachage unique

        return $prefix . $suffix;
    }

    // Override de la méthode create pour générer la reservation_id
    public static function create(array $attributes = [])
    {
        $attributes['reservation_id'] = static::generateReservationId();

        return parent::create($attributes);
    }

}
