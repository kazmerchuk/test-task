<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testSuccessfulLogin()
    {
        $response = $this->json('POST', '/api/login', ['login' => 'FOO_1234', 'password' => 'foo-bar-baz']);

        $response->assertStatus(200);
    }

    public function testFailureLogin()
    {
        $response = $this->json('POST', '/api/login', ['login' => 'ABC_1234', 'password' => 'foo-bar-baz']);

        $response->assertStatus(422);
    }
}
