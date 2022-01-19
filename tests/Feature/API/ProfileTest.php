<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesUser;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;
    use CreatesUser;

    public function test_fetch_profile()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $response = $this->getJson('/profile');

        $response->assertStatus(200);
        $response->assertJson([
            'user' => $user->toArray(),
        ]);
    }

    public function test_update_profile_success()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $data = [
            'name' => 'Bob',
            'email' => 'bob@example.com',
        ];
        $response = $this->postJson('/profile', $data);

        $response->assertStatus(200);
        $user->refresh();
        $response->assertJsonFragment([
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
        ]);
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
    }

    public function test_update_profile_invalid()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $data = [
            'name' => 'Bob',
        ];
        $response = $this->postJson('/profile', $data);

        $response->assertStatus(422);
        $user->refresh();
    }
}
