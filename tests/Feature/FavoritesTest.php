<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
        
    }

    /** @test */
    public function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        // /threads/channel/ch_id/reply/re_id/favorite
        // /replies/id/favorite
        // /replies/id/favorites    <------------- SELECTED
        // /favorites <-- reply_id
        
        /////////////////////////////////
        // THE SIMPLIEST POSSIBLE URI  //
        /////////////////////////////////
        $this->signIn();        

        $reply = create('App\Reply');
        
        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites); 

    }
    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();        

        $reply = create('App\Reply');

        try {
            $this->post('/replies/' . $reply->id . '/favorites');
            $this->post('/replies/' . $reply->id . '/favorites');            
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record twice (user_id, favorited_id, favorited_type)');
        }
        

        $this->assertCount(1, $reply->favorites); 
        
    }
}
