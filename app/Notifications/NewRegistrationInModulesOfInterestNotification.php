<?php

declare (strict_types = 1);

namespace App\Notifications;

use App\Mail\NewRegistrationInModulesOfInterestMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class NewRegistrationInModulesOfInterestNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $users;
    public $url;
    public $message;
    public $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($users, $url, $message, $title)
    {
        $this->users = $users;
        $this->url = $url;
        $this->message = $message;
        $this->title = $title;
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
        $mail = new NewRegistrationInModulesOfInterestMail($notifiable, $this->users, $this->url, $this->message, $this->title);
        return $mail->to($notifiable->correo);
    }

}
