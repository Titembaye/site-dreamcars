<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facture extends Model
{
    use SoftDeletes;
    use HasFactory;
    //protected $primaryKey = 'facture_id';
    //public $incrementing = false;

    protected $fillable = [
        'facture_id',
        'date_emission',
        'montant',
        'nom',  
    ];

    public function reservation(){
        return $this->belongsTo(Reservation::class,'reservation_id', 'reservation_id');
    }

    public static function generateFactureId()
    {

        $prefix = 'FA';
        $suffix = substr(md5(uniqid(rand(), true)), 0, 4);

        return $prefix . $suffix;
    }

    // Override de la méthode create pour générer la facture_id
    public static function create(array $attributes = [])
    {
        $attributes['facture_id'] = static::generateFactureId();

        return parent::create($attributes);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $prefix = 'FACTURE N°';
            $year = date('Y');
            $suffix = '/DC/AG';

            $lastFacture = self::orderBy('created_at', 'desc')->first();

            if ($lastFacture) {
                // Extraire le numéro de la dernière facture et incrémenter
                $lastNumber = intval(substr($lastFacture->facture_id, strlen($prefix)));
                $newNumber = $lastNumber + 1;
            } else {
                // Si c'est la première facture, commencer à 1
                $newNumber = 1;
            }

            // Formater le numéro avec des zéros à gauche (par exemple, 001, 002, ..., 010, ...)
            $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            // Construire le numéro de facture final
            $model->facture_id = $prefix . $formattedNumber . '/' . $year . $suffix;
            $model->nom = $model->facture_id;
        });
    }



}
