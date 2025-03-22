<?php
namespace App\Notifications;

use App\Models\Candidatures;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatutCandidatureModifie extends Notification
{
    use Queueable;

    public $candidature;

    public function __construct(Candidatures $candidature)
    {
        $this->candidature = $candidature;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Mise à jour du statut de votre candidature')
            ->line('Le statut de votre candidature pour l\'annonce "' . $this->candidature->annonce->titre . '" a été modifié.')
            ->line('Nouveau statut : ' . $this->candidature->statut)
            ->action('Voir l\'annonce', url('/annonces/' . $this->candidature->annonce_id))
            ->line('Merci pour votre confiance !');
    }
}