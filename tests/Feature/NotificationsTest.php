<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_notification_is_prepared_for_thread_subscribers_when_has_new_reply_not_by_current_user()
    {
        $this->signIn();

        $thread = create('App\Thread')->subscribe();

        // add user reply (must not be notified)
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply to the thread'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        //add another user reply (must be notified)
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some reply to the thread'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $this->signIn();

        $thread = create('App\Thread')->subscribe();

        //add another user reply (must be notified)
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some reply to the thread'
        ]);

        $user = auth()->user();

        $response = $this->getJson("/profiles/{$user->name}/notifications/")->json();

        $this->assertCount(1,$response);
    }

    /** @test */
    public function a_user_can_mark_notifications_as_read()
    {
        $this->signIn();

        $thread = create('App\Thread')->subscribe();

        //add another user reply (must be notified)
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some reply to the thread'
        ]);

        $user = auth()->user();
        $this->assertCount(1, $user->fresh()->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        //when user delete notifications
        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        //should be none
        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
