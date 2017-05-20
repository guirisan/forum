<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Thread;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_may_not_participate_in_forum_threads()
    {
        
        $this->expectException('Illuminate\Auth\AuthenticationException'); //thanks to RepliesController@__construct, wich includes auth middleware
        
        $this->post('/threads/1/replies', []);
        
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);

    }


}

