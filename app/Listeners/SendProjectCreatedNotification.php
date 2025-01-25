<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\ProjectCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ProjectCreatedNotification;

class SendProjectCreatedNotification
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
    public function handle(ProjectCreated $event)
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get();  

        foreach ($admins as $admin) {
            $admin->notify(new ProjectCreatedNotification($event->project));
        }
    }
}
