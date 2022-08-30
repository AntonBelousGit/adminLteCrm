<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    public string $method = 'get';

    public function testCompanyClientReturnRightStructure()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $company->clients()->attach($client);

        $this->actingAsUser($user);
        $response = $this->json($this->method, '/api/clients', ['company_id' => $company->id]);

        $response->assertJsonStructure([
            "data" => [
                'id',
                "company_name",
                "email",
                "phone",
                "web",
                "clients" => [
                    'data' => [
                        '*' => [
                            'id',
                            'client_name',
                            'email',
                            'site',
                            'phone'
                        ]
                    ],
                    'pagination' => [
                        'total',
                        'count',
                        'per_page',
                        'current_page',
                        'total_pages'
                    ]
                ]
            ],
        ]);
    }

    public function testCompanyClientReturn()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $company->clients()->attach($client);

        $this->actingAsUser($user);
        $response = $this->json($this->method, '/api/clients', ['company_id' => $company->id]);

        $this->assertEquals($company->id, $response['data']['id']);
        $this->assertEquals($client->id, $response['data']['clients']['data'][0]['id']);
    }

    public function testCompanyClientWithParams()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $client = Client::factory(20)->create();
        $company->clients()->attach($client);

        $this->actingAsUser($user);
        $response = $this->json($this->method, '/api/clients', ['company_id' => $company->id,'pagination' => 10, 'page' => 2]);

        $this->assertEquals($company->id, $response['data']['id']);
        $this->assertCount(10, $response['data']['clients']['data']);
        $this->assertEquals(2, $response['data']['clients']['pagination']['current_page']);
    }

    public function testFailGetCompanyWithClientUnauthenticated()
    {
        $response = $this->json($this->method, '/api/clients', ['company_id' => '']);
        $response->assertStatus(401);

        $response->assertJson([
            "message" => "Unauthenticated.",
        ]);
    }
}
