<?php

namespace App\Services;

use App\Exceptions\IncorrectPasswordException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserService
{
    public function updateUser(User $user, array $data): User
    {
        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * @throws IncorrectPasswordException
     */
    public function changeUserPassword(User $user, string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new IncorrectPasswordException();
        }
        $user->password = Hash::make($newPassword);
        $user->save();
    }

    public function resetUserPassword(string $email, string $password, string $token)
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'token' => $token,
        ];

        return Password::reset(
            $credentials,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );
    }
}
