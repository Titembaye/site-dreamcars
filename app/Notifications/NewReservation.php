<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class NewReservation extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Une nouvelle réservation a été effectuée.')
            ->line('Nom du client: ' . $notifiable->name)
            ->line('Voiture réservée: ' . $this->reservation->voiture->marque)
            ->line('Immatriculation: '.$this->reservation->voiture->immatriculation)
            ->action('Voir la réservation', url('/reservations/' . $this->reservation->id))
            ->line('Merci de faire affaire avec nous !');
    }

    public function toArray($notifiable)
    {
        return [
            // Les données que vous souhaitez transmettre à la notification
            'reservation_id' => $this->reservation->id,
            'message' => 'Une nouvelle réservation a été effectuée.',
        ];
    }
}
