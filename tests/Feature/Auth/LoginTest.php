<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @var string
     */
    public string $method = 'post';
    /**
     * @var string
     */
    private string $uri = '/api/token';

    public function testGetToken()
    {
        $user = User::factory()->create();
        $response = $this->json($this->method, $this->uri, [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertNotEmpty($response['token']);
    }

    public function testGetTokenFail()
    {
        $user = User::factory()->create();
        $response = $this->json($this->method, $this->uri, [
            'email' => $user->email,
            'password' => '123',
        ]);

        $response->assertStatus(422);

        $response->assertJsonFragment([
            "The provided credentials are incorrect.",
        ]);
    }
}
