<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    protected function actingAsUser(User $user = null): User
    {
        $user = $user ?? User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

}
