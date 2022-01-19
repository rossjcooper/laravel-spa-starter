<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\CreatesUser;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use DatabaseMigrations;
    use CreatesUser;

    public function test_change_password()
    {
        $user = $this->createUser();
        $newPassword = 'newPassword123';
        $data = [
            'currentPassword' => $this->password,
            'newPassword' => $newPassword,
            'confirmPassword' => $newPassword,
        ];
        $this->actingAs($user);
        $response = $this->postJson('/changePassword', $data);
        $response->assertStatus(200);
        $user->refresh();
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    public function test_change_password_wrong()
    {
        $user = $this->createUser();
        $newPassword = 'newPassword123';
        $data = [
            'currentPassword' => 'wrongPassword',
            'newPassword' => $newPassword,
            'confirmPassword' => $newPassword,
        ];
        $this->actingAs($user);
        $response = $this->postJson('/changePassword', $data);
        $response->assertStatus(422);
        $user->refresh();
        $this->assertTrue(Hash::check($this->password, $user->password));
    }
}
