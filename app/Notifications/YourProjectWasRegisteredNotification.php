<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class YourProjectWasRegisteredNotification extends Notification
{
    private $project;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
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
            ->subject(sprintf('Tu proyecto %s fue registrado correctamente', $this->project->name))
            ->line(sprintf('Te informamos que tu proyecto de nombre <strong>%s</strong> fue registrado y se encuentra en proceso de tu revisión. Recibirás un correo una vez que tu proyecto sea aprobado o rechazado.', $this->project->name))
            ->line(
                sprintf(
                    'Por lo pronto puedes ingresar a <a href="%s">tu cuenta</a> desde donde encontrarás un enlace para <a href="%s">previsualizar tu proyecto</a>
                    o modificar los datos mientras se encuentre en revisión.',
                    route('account.index'),
                    route('projects.show', $this->project)
                )
            )
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
