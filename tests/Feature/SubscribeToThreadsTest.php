<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        // given a signed user
        $this->signIn();

        // and given a thread
        $thread = create('App\Thread');

        //when the user subscribes to thread
        $this->post($thread->path() . '/subscriptions');

        // each time reply is left on thread
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply to the thread'
        ]);

        // a notification is prepared for the user
        $this->assertCount(1, auth()->user()->notifications);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->delete($thread->path() . '/subscriptions');        

        $this->assertCount(0, $thread->subscriptions);
    }    
}
