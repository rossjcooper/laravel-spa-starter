<?php

namespace App\Services;

use App\Exceptions\IncorrectPasswordException;
use App\Models\User;
use App\Notifications\NewPasswordNotification;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class UserService
{
    public function createUser(array $data, bool $emailPassword = false): User
    {
        $password = $data['password'];
        $user = new User($data);
        $this->setUserPassword($user, $password);
        $user->save();

        $user->notify(new WelcomeUserNotification($user, $emailPassword ? $password : null));

        return $user;
    }

    public function updateUser(User $user, array $data, bool $emailPassword = false): User
    {
        $user->fill($data);
        if (isset($data['password']) && $data['password']) {
            $this->setUserPassword($user, $data['password']);
        }
        $user->save();
        if (isset($data['password']) && $data['password'] && $emailPassword) {
            $user->notify(new NewPasswordNotification($user, $data['password']));
        }


        return $user;
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    /**
     * @throws IncorrectPasswordException
     */
    public function changeUserPassword(User $user, string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new IncorrectPasswordException();
        }
        $this->setUserPassword($user, $newPassword);
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
                $this->setUserPassword($user, $password);
                $user->save();
            }
        );
    }

    public function searchUsers($keyword = null): Builder
    {
        $query = User::query();
        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        return $query;
    }

    public function setUserPassword(User $user, string $password): void
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
    }
}
