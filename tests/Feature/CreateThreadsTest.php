<?php

namespace Tests\Feature;

use App\Activity;
use App\Rules\Recaptcha;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        app()->singleton(Recaptcha::class, function (){

            return \Mockery::mock(Recaptcha::class, function($m){
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    /** @test */
    public function guests_can_not_create_new_threads()
    {
        $this->withExceptionHandling();

        $this->post(route('threads'))
            ->assertRedirect(route('login'));

        $this->get('/threads/create')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function new_users_must_firm_confirm_their_email_adress_before_creating_threads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();
        $this->signIn($user);

        $thread  = make('App\Thread');

        return $this->post(route('threads'), $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'you must confirm email');
    }

     /** @test */
    public function a_user_can_create_new_forum_threads()
    {
        $response = $this->publishThread(['title' => 'Some title', 'body' => 'Some body']);

        $this->get($response->headers->get('Location'))
            ->assertSee('Some title')
            ->assertSee('Some body');

    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread([ 'title' => null ])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread([ 'body' => null ])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThread([ 'g-recaptcha-response' => 'test' ])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    public function a_thread_requires_a_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread([ 'channel_id' => null ])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread([ 'channel_id' => 999 ])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Foo Title']);

        $this->assertEquals($thread->fresh()->slug, 'foo-title');

        $thread = $this->postJson(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }

    /** @test */
    public function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Some Title 24']);

        $thread = $this->postJson(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);
        // $this->assertTrue(Thread::whereSlug("some-title-24-{$thread['id']}")->exists());
    }

    /** @test */
    public function unauthorized_users_can_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        //lesson 28: when thread is deleted, activities associated must be removed too
        // $this->assertDatabaseMissing('activities', [
        //     'subject_id' => $thread->id,
        //     'subject_type' => get_class($thread)
        // ]);
        // $this->assertDatabaseMissing('activities', [
        //     'subject_id' => $reply->id,
        //     'subject_type' => get_class($reply)
        // ]);

        // En compte de comprovar que no existixen eixos registres a la BD
        // comprovem que la taula d'activitats està buida, que en este cas és equivalent
        $this->assertEquals(0,Activity::count());
    }



    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token']);
    }

}
