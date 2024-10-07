<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactUsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $messageData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messageData)
    {
        $this->messageData = $messageData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact Us')
            ->html((new MailMessage)
                ->greeting('')
                ->line('Name: '.$this->messageData['name'])
                ->line('Email: '.$this->messageData['email'])
                ->line($this->messageData['body'])
                ->render()
            );
    }
}
