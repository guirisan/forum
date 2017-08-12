<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SpamTest extends TestCase
{

    /** @test */
    public function it_checks_invalid_keywords()
    {
        // invalid keywords
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply'));
        
        $this->expectException('Exception');

        $spam->detect('yahoo customer support');
    }

    /** @test */
    public function it_checks_any_key_being_held_down()
    {
        // pulsacio de tecla repetida més de 4 vegades
        $spam = new Spam;

        $this->expectException('Exception');

        $spam->detect('Hola mundooooooooooooooo!');


        
    }
}
