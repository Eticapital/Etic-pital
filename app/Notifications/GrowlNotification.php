<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GrowlNotification extends Notification
{
    use Queueable;

    private $title;
    private $body;
    private $type;
    private $showCloseButton;
    private $showIcon;
    private $duration;
    private $options;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        $body,
        $level = 'success',
        $title = null,
        $showIcon = false,
        $showCloseButton = true,
        $duration = null
    )
    {
        if (is_array($body)) {
            $this->options = array_replace([
                'title' => $title,
                'level' => $level,
                'showCloseButton' => $showCloseButton,
                'showIcon' => $showIcon,
                'id' => uniqid(),
                'duration' => $duration,
            ], $body);
        } else {
            $this->title = $title;
            $this->body = $body;
            $this->level = $level;
            $this->showCloseButton = $showCloseButton;
            $this->duration = $duration;
            $this->showIcon = $showIcon;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->options ? $this->options : [
            'title' => $this->title,
            'body' => $this->body,
            'level' => $this->level,
            'showCloseButton' => $this->showCloseButton,
            'showIcon' => $this->showIcon,
            'id' => uniqid(),
            'duration' => $this->duration,
        ];
    }
}
