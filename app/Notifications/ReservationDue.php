<?php
    
    // app/Notifications/ReservationDue.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationDue extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * La réservation.
     *
     * @var \App\Models\Reservation
     */
    protected $reservation;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Reservation $reservation
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $reservation = $this->reservation;

        return (new MailMessage)
            ->line('La réservation de la voiture est arrivée à échéance.')
            ->line('Voiture: ' . $reservation->voiture->immatriculation)
            ->line('Date de début: ' . $reservation->date_debut)
            ->line('Date de fin: ' . $reservation->date_fin)
            ->line('Heure de fin: ' . $reservation->heure_fin)
            ->action('Voir la réservation', url('/reservations/' . $this->reservation->id))
            ->line('Merci d\'utiliser notre service de réservation.');
    }

    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'message' => 'La réservation a expiré.',
        ];
    }
}
