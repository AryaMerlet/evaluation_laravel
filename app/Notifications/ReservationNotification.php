<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reunion\Reservation;

class ReservationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Reservation */
    protected Reservation $reservation;

    /** @var string */
    protected string $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reservation $reservation, string $action)
    {
        $this->reservation = $reservation;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     * @param object $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * @param object $notifiable
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = new MailMessage;

        if ($this->action === 'created') {
            return $message
                ->subject('Nouvelle réservation créée')
                ->line('Une nouvelle réservation a été effectuée.')
                ->line('Salle : ' . $this->reservation->salle->name)
                ->line('Date : ' . $this->reservation->date)
                ->line('Heure de début : ' . $this->reservation->heure_debut)
                ->line('Heure de fin : ' . $this->reservation->heure_fin)
                ->line('Merci d’utiliser notre service !');
        }

        if ($this->action === 'deleted') {
            return $message
                ->subject('Réservation annulée')
                ->line('Une réservation a été annulée.')
                ->line('Salle : ' . $this->reservation->salle->name)
                ->line('Date : ' . $this->reservation->date)
                ->line('Heure de début : ' . $this->reservation->heure_debut)
                ->line('Heure de fin : ' . $this->reservation->heure_fin)
                ->line('Merci d’utiliser notre service !');
        }

        // Par défaut, on retourne un message neutre
        return $message
            ->subject('Mise à jour de réservation')
            ->line('Une réservation a été modifiée.');
    }

    /**
     * Get the array representation of the notification.
     * @param object $notifiable
     * @return array<string, int|string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'action' => $this->action,
        ];
    }
}
