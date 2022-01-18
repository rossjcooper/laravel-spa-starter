<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
	public function changePassword(ChangePasswordRequest $request): Response
	{
		$user = $request->user();
		if (!Hash::check($request->get('currentPassword'), $user->password)) {
			return response([
				'errors' => [
					'currentPassword' => ['Incorrect current password'],
				]
			], Response::HTTP_UNPROCESSABLE_ENTITY);
		}
		$user->password = Hash::make($request->newPassword);
		$user->save();

		return response('');
	}
}
