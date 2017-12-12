<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function non_administrators_cant_lock_threads()
    {
        $this->withExceptionHandling()
            ->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id() ]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(403);

        $this->assertFalse( $thread->fresh()->locked);
    }

    /** @test */
    public function administrators_can_lock_any_thread()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id() ]);

        $this->post(route('locked-threads.store', $thread));

        $this->assertTrue( $thread->fresh()->locked, 'Failed asserting that the thread is locked');
    }

    /** @test */
    public function administrators_can_unlock_any_thread()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id(), 'locked' => true ]);

        $this->delete(route('locked-threads.destroy', $thread));

        $this->assertFalse( $thread->fresh()->locked, 'Failed asserting that the thread is unlocked');
    }

    /** @test */
    public function once_thread_is_locked_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = create('App\Thread', ['locked' => true]);

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => create('App\User')->id
        ])->assertStatus(422);
    }
}
