<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Channel extends TestCase
{
    use DatabaseMigrations;
    
    // protected $thread;
    
    public function setUp()
    {
        parent::setUp();
        // $this->thread = create('App\Thread');
        
    }

    /** @test */
    public function a_channel_has_some_threads()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread', ['channel_id' => $channel->id ]);

        $this->assertTrue($channel->threads->contains($thread));
        
    }

    // /** @test */
    // public function a_thread_has_a_creator()
    // {
    //     $this->assertInstanceOf('App\User', $this->thread->owner);
    // }

    
    // /** @test */
    // public function a_thread_has_replies()
    // {
    //     $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    // }
    
    // /** @test */
    // public function a_thread_can_add_a_reply()
    // {
    //     $this->thread->addReply([
    //         'body' => 'foo body',
    //         'user_id' => 1
    //     ]);

    //     $this->assertCount(1, $this->thread->replies);
    // }

    // /** @test */
    // public function a_thread_belongs_to_a_channel()
    // {
    //     $thread = make('App\Thread');
    //     $this->assertInstanceOf('App\Channel', $thread->channel);
    // }

}
