<?php

declare (strict_types = 1);

namespace App\Listeners;

use App\Events\NewRegistrationInModulesOfInterestEvent;
use App\Notifications\NewRegistrationInModulesOfInterestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NewRegistrationInModulesOfInterestListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewRegistrationInModulesOfInterestEvent $event)
    {
        $event->users->each->notify(new NewRegistrationInModulesOfInterestNotification($event->users, $event->url, $event->message, $event->title));
    }

    /**
     * Handle a job failure.
     *
     * @param  Databyte\WhmCpanelManager\Events\NewRegistrationInModulesOfInterestEvent  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(NewRegistrationInModulesOfInterestEvent $event, $exception)
    {
        Log::error(__("New registration in modules of interest cannot be sent to user"), [
            'errors' => json_encode($exception->getMessage()),
            'code' => $exception->getCode(),
        ]);
    }
}
