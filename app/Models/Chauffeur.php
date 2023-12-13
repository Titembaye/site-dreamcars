<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginates\Concerns\PaginatesAttributes;

class Chauffeur extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'nom',
        'prenom',
        'phone',
        'email',
        'permis_de_conduire',
        'agence_id',
    ];

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function missions()
    {
        return $this->belongsToMany(Mission::class, 'mission_chauffeur', 'chauffeur_id', 'mission_id');
    }
}
