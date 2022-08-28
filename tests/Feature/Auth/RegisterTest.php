<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Str;
use Tests\TestCase;
use Faker\Generator;

class RegisterTest extends TestCase
{
    /**
     * @var string
     */
    public string $method = 'post';
    /**
     * @var string
     */
    private string $uri = 'api/client/register';

    public function testSuccessRegistration(): void
    {
        $faker = app(Generator::class);
        $response = $this->json($this->method, $this->uri, [
            'name' => Str::random(30),
            'email' => $faker->email(),
            'password' => $faker->password(),
        ]);

        $client = User::query()->latest()->first();

        $response->assertJson([
            'result' => [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'instagram_url' => $client->instagram_url,
                'facebook_url' => null,
                'type_mobile_token' => null,
                'mobile_token' => null,
                'language_id' => null,
                'banned_to' => null,
                'reason_of_ban' => null,
                'timezone' => 'UTC',
                'token' => $client->devices()->latest()->first()->api_token,
                'offers_count' => 0,
                'full_name' => $client->full_name,
                'picture' => null,
                'social_accounts' => null,
            ],
            'code' => 201,
        ]);
    }


    public function testBasic()
    {

        $this->actingAsUser();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
