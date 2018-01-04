<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActivationEmailToUsersNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            ->subject('Activa tu cuenta en Eticapital')
            ->line(sprintf('Recibiste este correo porque realizaste una promesa de inversión en Eticapital, sin embargo no detectamos ningún usuario activo con tu correo %s.', $notifiable->email))
            ->line('Tu usuario te ayudará a poder llevar un mejor seguimiento de tus promesas de inversión y en el futuro recibir notificaciones sobre el proyecto.')
            ->line('Para activar tu cuenta de usuario sigue el siguiente enlace:')
            ->action('Activar mi cuenta de usuario', route('account.activate', ['email' => $notifiable->email, 'token' => $notifiable->activation_token]));
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
