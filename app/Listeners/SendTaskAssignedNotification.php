<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\TaskAssignedNotification;

class SendTaskAssignedNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle(TaskAssigned $event)
    {
        $event->task->assignedUser->notify(new TaskAssignedNotification($event->task));
    }
}
