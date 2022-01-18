<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): Response
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return response([
                'user' => Auth::user(),
            ]);
        }

        return response([
           'errors' => [
                'password' => ['Incorrect login credentials'],
           ],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
