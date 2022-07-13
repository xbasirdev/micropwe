<?php

declare(strict_types = 1);

namespace App\Events;
use Illuminate\Queue\SerializesModels;

class NewRegistrationInModulesOfInterestEvent extends Event
{
    use SerializesModels;
    
    public $users;
    public $url;
    public $message;
    public $title;
    

    /**
     * Create a new event instance.
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
}
