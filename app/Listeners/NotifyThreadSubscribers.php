<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyThreadSubscribers
{
    
    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        $event->reply->thread
            ->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each
            ->notify($event->reply);
    }
}
