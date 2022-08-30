<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    public string $method = 'get';

    public function testClientCompanyReturnRightStructure()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $client->companies()->attach($company);

        $this->actingAsUser($user);
        $response = $this->json($this->method, '/api/client_companies', ['client_id' => $client->id]);

        $response->assertJsonStructure([
            "data" => [
                'id',
                "client_name",
                "email",
                "phone",
                "web",
                "companies" => [
                    '*' => [
                        'id',
                        'company_name',
                        'email',
                        'phone',
                        'web'
                    ]
                ]
            ],
        ]);
    }

    public function testClientCompanyReturn()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $client->companies()->attach($company);

        $this->actingAsUser($user);
        $response = $this->json($this->method, '/api/client_companies', ['client_id' => $client->id]);
        $this->assertEquals($client->id, $response['data']['id']);
        $this->assertEquals($company->id, $response['data']['companies'][0]['id']);
    }

    public function testFailGetClientWithCompanyUnauthenticated()
    {
        $response = $this->json($this->method, '/api/client_companies', ['client_id' => '']);
        $response->assertStatus(401);

        $response->assertJson([
            "message" => "Unauthenticated.",
        ]);
    }
}
