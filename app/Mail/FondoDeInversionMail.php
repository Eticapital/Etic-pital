<?php

namespace App\Mail;

use App\Models\Sector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FondoDeInversionMail extends Mailable
{
    protected $data;


    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->data['sectors'] = collect($this->data['sectors'])->map(function ($sector_id) {
            return Sector::findOrFail($sector_id)->label;
        });
        return $this
            ->subject('Formulario para aplicar a fondo de inversión')
            ->markdown('emails.fondo-de-inversion')
            ->with($this->data);
    }
}
