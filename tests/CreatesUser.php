<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait CreatesUser
{
    protected $email = 'john@example.com';
    protected $password = 'password1234';

    protected function createUser(): User
    {
        $user = new User([
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'name' => 'John Doe'
        ]);
        $user->save();

        return $user;
    }
}
