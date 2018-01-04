<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewProjectInvestmentNotification extends Notification
{
    private $project;
    private $investment;

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
            ->subject(sprintf('Se recibió una promesa de inversión para %s', $this->project->name))
            ->line(sprintf('Se recibió una promesa de inversión de <strong>%s</strong> por <strong>%s</strong> para el proyecto <strong>%s</strong> del usuario <strong>%s</strong>.',
                $this->investment->name,
                money($this->investment->amount),
                $this->project->name,
                $this->project->owner->name . ' &lt;' . $this->project->owner->email . '>'
            ))
            ->line(sprintf(
                '
                    <p>Los datos del posible inversionista son los siguientes:<p>
                    <p>
                        Nombre: %s <br />
                        Correo electrónico: %s <br />
                        Teléfono: %s <br />
                        Residencia: %s <br />
                        Organización: %s
                    </p>
                ',
                $this->investment->name,
                $this->investment->email,
                $this->investment->phone,
                $this->investment->residence,
                $this->investment->organization
            ))
            ->line('Por favor ponte en contacto con el posible inversionista y el dueño del proyecto para informarle de los siguientes pasos.')
            ->line('Puedes revisar tus promesas de inversión y cambiar su estatus desde el administrador de contenido del sistema:')
            ->action('Ir al administrador', url(config('app.url').'/admin'));
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
