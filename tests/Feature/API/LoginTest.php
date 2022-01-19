<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\CreatesUser;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    use CreatesUser;

    public function test_login_success()
    {
        $user = $this->createUser();

        $response = $this->postJson('/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'user' => $user->toArray(),
        ]);
    }

    public function test_login_fail()
    {
        $this->createUser();

        $response = $this->postJson('/login', [
            'email' => $this->email,
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'password' => ['Incorrect login credentials',],
            ],
        ]);
    }
}
