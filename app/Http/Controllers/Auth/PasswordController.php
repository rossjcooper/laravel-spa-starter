<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\IncorrectPasswordException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request, UserService $service): Response
    {
        $user = $request->user();
        try {
            $service->changeUserPassword($user, $request->get('currentPassword'), $request->get('newPassword'));
        } catch (IncorrectPasswordException $e) {
            return response([
                'errors' => [
                    'currentPassword' => ['Incorrect current password',],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response('');
    }
}
