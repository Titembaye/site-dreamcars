<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Support\Facades\Log;

class NotificationSendingListener
{
    public function handle(NotificationSending $event)
    {
        $notification = $event->notification;
        $notifiable = $event->notifiable;

        // Vérifiez si la notification a déjà été envoyée
        if ($notifiable->notification_sent_at === null) {
            // La notification n'a pas encore été envoyée, déclenchez-la
            $notifiable->notify($notification);

            // Marquez la réservation comme notification envoyée
            $notifiable->update(['notification_sent_at' => now()]);

            Log::info('Notification envoyée avec succès.', [
                'notifiable' => $notifiable,
                'notification' => $notification,
            ]);
        } else {
            Log::info('La notification a déjà été envoyée.', [
                'notifiable' => $notifiable,
                'notification' => $notification,
            ]);
        }
    }
}
