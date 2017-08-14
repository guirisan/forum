<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;
   
    /** @test */
    public function it_has_an_owner()
    {
        $reply = create('App\Reply');
        
        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());
        
        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = create('App\Reply', [
            'body' => '@jane wants to @john'
        ]);

        $this->assertEquals(['jane', 'john'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_mentioned_usernames_in_the_body_with_anchor_tags_which_link_to_profile()
    {
        $reply = new \App\Reply([
            'body' => '@jane. wants some link.'
        ]);

        $this->assertEquals(
            '<a href="/profiles/jane">@jane</a>. wants some link.',
            $reply->body
        );
    }
}
