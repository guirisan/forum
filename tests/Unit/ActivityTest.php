<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;
   
    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type'          => 'created_thread',
            'user_id'       => auth()->id(),
            'subject_id'    => $thread->id,
            // 'subject_type'  => get_class($thread) //will be valid?
            'subject_type'  => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);

    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());

        // $this->assertDatabaseHas('activities', [
        //     'type'          => 'created_reply',
        //     'user_id'       => auth()->id(),
        //     'subject_id'    => $reply->id,
        //     // 'subject_type'  => get_class($reply) //will be valid?
        //     'subject_type'  => 'App\Reply'
        // ]);

        // $activity = Activity::first();

        // $this->assertEquals($activity->subject->id, $reply->id);

    }


    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        // we have a thread
        $thread = create('App\Thread', ['user_id' => auth()->id()], 2);
        
        // // and another thread from week ago
        // $threadFromWeekAgo = create('App\Thread', [
        //     'user_id' => auth()->id(),
        //     'created_at' => Carbon::now()->subWeek()
        // ]);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        
        // when we fetch their feed
        $feed = Activity::feed(auth()->user());

        // threads should be returned in proper format / order?
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
        
        // threads should be returned in proper format / order?
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));

    }
}
