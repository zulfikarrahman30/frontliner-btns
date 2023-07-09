<?php

namespace App\Listeners;

use App\Events\RequestChat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChatNotification 
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
     * @param  \App\Events\RequestChat  $event
     * @return void
     */
    public function handle(RequestChat $event)
    {
        //
    }
}
