<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    protected function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->body);
    }

    // /** @test */
    // function a_user_can_read_replies_associated_to_single_thread()
    // {
    //     $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

    //     $this->get($this->thread->path())
    //         ->assertSee($reply->body);
    // }


    /** @test */
    public function a_user_can_filter_all_channel_threads()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', [ 'channel_id' => $channel->id ]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id() ]);
        $threadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }
    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        //Given 3 threads
        //With 2 replies, 3 replies and 0 replies
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithZeroReplies = $this->thread;


        //When the user filter all trheads by popularity
        $response = $this->getJson('threads?popular=1')->json();

        //Then they should be returned ordered from most replies to least
        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    /** @test */
    public function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test */
    public function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id], 2);
        // dd($thread->replies);
        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }

    /** @test */
    public function we_record_a_new_visit_each_time_the_thread_is_read()
    {
        $thread = create('App\Thread');

        $this->assertSame(0,$thread->visits);

        $this->call('GET', $thread->path());

        $this->assertEquals(1,$thread->fresh()->visits);

    }


}
