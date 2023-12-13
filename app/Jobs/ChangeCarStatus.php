<?php

namespace App\Jobs;
use Illuminate\Support\Facades\Log;
use App\Models\Reservation;
use App\Models\Voiture;
use App\Models\DisponibiliteVehicule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeCarStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        Log::info('Handling CheckReservationStatus job.');
        // Récupérez toutes les réservations expirées
        $expiredReservations = Reservation::where('heure_fin', '<=', now())
        ->whereHas('voiture.disponibilite', function ($query) {
            $query->where('statut', 'Réservé');
        })
        ->get();

            foreach ($expiredReservations as $reservation) {
                // Récupérez la voiture associée à la réservation
                $voiture = Voiture::find($reservation->voiture_id);
            
                // Mettez ici la logique pour mettre à jour le statut de la voiture
                if ($voiture) {
                    $voiture->disponibilite->update(['statut' => 'Disponible']); // Remplacez 'nouveau_statut' par le statut désiré
                }
            }            
    }
}
