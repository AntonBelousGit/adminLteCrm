<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    public string $method = 'get';


    public function testReturnRightStructure()
    {
        $user = User::factory()->create();
        Company::factory()->create();

        $this->actingAsUser($user);
        $response = $this->json($this->method, '/api/companies', []);
        $response->assertJsonStructure([
            "data" => [
                '*' => [
                    'id',
                    "company_name",
                    "site",
                    "phone",
                    "created_at",
                    "updated_at",
                    "email",
                ],
            ],
            "links" => [
                "first",
                "last",
                "prev",
                "next",
            ],
            "meta" => [
                "current_page",
                "from",
                "last_page",
                "links" => [
                    0 => [
                        "url",
                        "label",
                        "active",
                    ],
                    1 => [
                        "url",
                        "label",
                        "active",
                    ],
                    2 => [
                        "url",
                        "label",
                        "active",
                    ]
                ],
                "path",
                "per_page",
                "to",
                "total",
            ]
        ]);
    }

    public function testRightReturnCompany()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $this->actingAsUser($user);
        $response = $this->json($this->method, '/api/companies', []);

        $this->assertEquals($company->id, $response['data'][0]['id']);
        $this->assertEquals($company->company_name, $response['data'][0]['company_name']);
    }

    public function testRightReturnCompanyWithParams()
    {
        $user = User::factory()->create();
        Company::factory(100)->create();

        $this->actingAsUser($user);

        $response = $this->json($this->method, '/api/companies', ['pagination' => 10, 'page' => 2]);
        $this->assertCount(10, $response['data']);
        $this->assertEquals(2, $response['meta']['current_page']);
    }

    public function testFailGetCompaniesUnauthenticated()
    {
        $response = $this->json($this->method, '/api/companies', []);
        $response->assertStatus(401);

        $response->assertJson([
            "message" => "Unauthenticated.",
        ]);
    }
}
