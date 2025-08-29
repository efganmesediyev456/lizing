<?php

namespace App\Listeners;

use App\Events\DriverNotified;
use App\Mail\DriverNotificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendDriverNotificationEmail
{
    /**
     * Create the event listener.
     */
    use InteractsWithQueue;
   

    /**
     * Handle the event.
     */
    public function handle(DriverNotified $event): void
    {
        $driver = $event->driver;
        if($driver->email){
            Mail::to($driver->email)->send(new DriverNotificationMail($driver));
        }
    }
}
