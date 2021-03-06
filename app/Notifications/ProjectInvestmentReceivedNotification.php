<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProjectInvestmentReceivedNotification extends Notification implements ShouldQueue
{
    private $investment;
    private $project;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($investment)
    {
        $this->investment = $investment;
        $this->project = $investment->project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hola, ' . $notifiable->name)
            ->subject(sprintf('Recibiste una promesa de inversión para %s', $this->project->name))
            ->line(sprintf('Recibiste una promesa de inversión de <strong>%s</strong> por <strong>%s</strong> para tu proyecto <strong>%s</strong>.',
                $this->investment->name,
                money($this->investment->amount),
                $this->project->name
            ))
            ->line('Ponte en contacto con Eticapital para dar seguimiento a la promesa de inversión y en su caso cambiar el estatus a <strong>Aceptada</strong> o <strong>Rechazada</strong>. Solo se mostrará lo recaudado al marcar dentro del sistema una promesa de inversión como "aceptada".')
            ->line('Recuerda que puedes revisar tus promesas de inversión y cambiar su estatus desde la sección "mi cuenta" dentro de nuestro sistema')
            ->action('Ver promesas de inversión', route('account.investments', $this->project));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
