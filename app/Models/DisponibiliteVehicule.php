<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisponibiliteVehicule extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'voiture_id',
        'date_disponibilite',
        'statut',
    ];

    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

}
