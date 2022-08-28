<?php

namespace Tests\Feature;

use Tests\TestCase;

class ClientTest extends TestCase
{
    public function testBasic()
    {
        $this->actingAsClient();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
