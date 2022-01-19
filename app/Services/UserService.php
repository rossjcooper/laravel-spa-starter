<?php

namespace App\Services;

use App\Exceptions\IncorrectPasswordException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
}
