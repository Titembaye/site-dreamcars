<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Notification;
use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class SendReservationDueNotification extends Command
{
    protected $signature = 'send:reservation-due-notification';
    protected $description = 'Send due reservation notifications';

    public function handle()
    {
        $reservations = Reservation::whereNull('notification_sent_at')
            ->where('date_fin', '<=', now())
            ->get();

        foreach ($reservations as $reservation) {
            // Envoyer la notification par e-mail aux utilisateurs
            $user = $reservation->user;

            Notification::route('mail', $user->routeNotificationForMail())
                ->notify(new \App\Notifications\ReservationDue($reservation));

            // Envoyer la notification aux administrateurs
            $admins = User::where('role', 'admin')->get();

            Notification::send($admins, new \App\Notifications\NewReservation($reservation));

            // Mettre à jour la colonne notification_sent_at
            $reservation->update(['notification_sent_at' => now()]);
        }
    }
}
