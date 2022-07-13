<?php

declare (strict_types = 1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRegistrationInModulesOfInterestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $users;
    public $url;
    public $message;
    public $title;
    public $notifiable;
    public $email_draft;
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable, $users, $url, $message, $title)
    {
        $this->notifiable = $notifiable;
        $this->users = $users;
        $this->url = $url;
        $this->message = $message;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $email = $this
            ->subject($this->title)
            ->markdown('email.new-registration-in-modules-of-interest')
            ->from(env('MAIL_FROM'), env('MAIL_NAME'));

        return $email;
    }

}
