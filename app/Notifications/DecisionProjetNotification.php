<?php

namespace App\Notifications;

use App\Models\Projet;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;

// §9.4 : notifier de la décision (validation ou rejet) prise sur un projet soumis.
class DecisionProjetNotification extends Notification
{
    public function __construct(private Projet $projet, private string $decision, private ?string $motif = null)
    {
    }

    public function via(object $notifiable): array
    {
        // Les gestionnaires reçoivent la notification dans l'application ; la structure, par e-mail.
        return $notifiable instanceof AnonymousNotifiable ? ['mail'] : ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $valide = $this->decision === 'valide';
        $mail = (new MailMessage)
            ->subject('SGSPIP — Projet '.($valide ? 'validé' : 'rejeté').' : '.$this->projet->reference)
            ->greeting('Bonjour,')
            ->line('Décision prise sur le projet « '.$this->projet->intitule.' » ('.$this->projet->reference.') : '.($valide ? 'validé.' : 'rejeté.'));

        if (!$valide && $this->motif) {
            $mail->line('Motif : '.$this->motif);
        }

        return $mail->action('Consulter le projet', route('projets.show', $this->projet));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'projet_id' => $this->projet->id,
            'reference' => $this->projet->reference,
            'intitule' => $this->projet->intitule,
            'decision' => $this->decision, // valide | rejete
            'motif' => $this->motif,
        ];
    }
}
