<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_for_thread_subscribers_when_has_new_reply_not_by_current_user()
    {
        $thread = create('App\Thread')->subscribe();

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some body'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some body'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(1,$this->getJson("/profiles/" . auth()->user()->name . "/notifications")->json());
    }

    /** @test */
    public function a_user_can_mark_notifications_as_read()
    {
        create(DatabaseNotification::class);

        tap(auth()->user(), function ($user){
            $this->assertCount(1, $user->fresh()->unreadNotifications);

            $this->delete("/profiles/{$user->name}/notifications/" . $user->unreadNotifications->first()->id);

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }
}
