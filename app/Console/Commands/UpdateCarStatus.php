<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Voiture;

class UpdateCarStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-car-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update car statuses based on reservations';

    /**
     * Execute the console command.
     */
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
