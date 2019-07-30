<?php

namespace App\Listeners;

use App\Events\TstEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TstListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TstEvent  $event
     * @return void
     */
    public function handle(TstEvent $event)
    {
        //
    }
}
