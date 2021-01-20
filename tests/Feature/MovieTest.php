<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieTest extends TestCase
{
    public function testListAvailable()
    {
        $response = $this->get('/api/titles');

        $response->assertStatus(200);
    }
}
