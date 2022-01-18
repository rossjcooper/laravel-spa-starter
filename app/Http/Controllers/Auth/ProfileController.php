<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(): Response
	{
		return $this->respondWithUser(Auth::user());
	}

	public function update(UpdateProfileRequest $request)
	{
		/** @var User $user */
		$user = $request->user();
		$data = $request->only([
			'name',
			'email',
		]);
		$user->fill($data);
		$user->save();

		return $this->respondWithUser($user);
	}

	private function respondWithUser(User $user): Response
	{
		return response([
			'user' => $user,
		]);
	}
}
