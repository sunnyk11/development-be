<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Queue\InteractsWithQueue;

class LogConnectionFailed
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
     * @param  ConnectionFailed  $event
     * @return void
     */
    public function handle(ConnectionFailed $event)
    {
        //
    }
}
