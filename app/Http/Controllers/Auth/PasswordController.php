<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\IncorrectPasswordException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

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

    public function forgotPassword(ForgotPasswordRequest $request): Response
    {
        Password::sendResetLink(
            $request->only('email')
        );

        return response('');
    }

    public function resetPassword(ResetPasswordRequest $request, UserService $userService): Response
    {
        $status = $userService->resetUserPassword($request->get('email'), $request->get('password'), $request->get('token'));

        if ($status === Password::PASSWORD_RESET) {
            return response('');
        }
        return response([
            'errorCode' => $status,
        ], Response::HTTP_BAD_REQUEST);
    }
}
