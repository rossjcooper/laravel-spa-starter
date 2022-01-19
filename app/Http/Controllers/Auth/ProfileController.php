<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(): Response
    {
        return $this->respondWithUser(Auth::user());
    }

    public function update(UpdateProfileRequest $request, UserService $service)
    {
        /** @var User $user */
        $user = $request->user();
        $data = $request->only([
            'name',
            'email',
        ]);
        $service->updateUser($user, $data);

        return $this->respondWithUser($user);
    }

    private function respondWithUser(User $user): Response
    {
        return response([
            'user' => $user,
        ]);
    }
}
