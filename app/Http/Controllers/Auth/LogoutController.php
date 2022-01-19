<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request): Response
    {
        Auth::guard('web')->logout();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
