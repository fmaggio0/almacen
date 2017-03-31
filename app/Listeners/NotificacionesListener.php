<?php

namespace App\Listeners;

use App\Events\AutorizacionesEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificacionesListener
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
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(AutorizacionesEvent $event)
    {
        //dd($event);
        $links = [
            ['name' => 'jobs', 'url' => url('jobs') ],
            ['name' => 'series', 'url' => url('series') ],
            ['name' => 'courses', 'url' => url('courses') ],
        ];
        return $links;
    }
}
