<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProjectInvestmentSendedNotification extends Notification implements ShouldQueue
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
            ->subject('Realizaste una promesa de inversión')
            ->line(sprintf('Realizaste una promesa de inversión de <strong>%s</strong> para el proyecto <strong>%s</strong>. Por lo pronto tu promesa de inversión se encuentra en proceso de revisión.',
                money($this->investment->amount),
                $this->project->name
            ))
            ->line('Para aprobar tu inversión deberás cumplir los siguientes requisitos')
            ->line('<ul>
                <li>Ser contactado por Eticapital</li>
                <li>Agendar una cita con Eticapital y el Dueño de Proyecto.</li>
                <li>Una vez validada la información se marcará tu inversión como aprobada/rechazada según sea el caso</li>
            </ul>')
            ->line('A la brevedad el dueño del proyecto debería contactarte para informarte de los siguientes pasos.')
            ->line('Recuerda que puedes revisar el estatus de tu promesa de inversión desde tu cuenta.')
            ->action('Ir a mi cuenta', route('account.index'));
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
