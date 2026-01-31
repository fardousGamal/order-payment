<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\API\LoginRequest;
use Modules\Auth\Http\Requests\API\RegisterRequest;
use Modules\Auth\Http\resources\API\LoginResource;


class AuthController extends Controller
{
    public function register(RegisterRequest $request){

        $token = $request->register();
        return ApiResponse::successResponse(LoginResource::make($token), __('Successfully create user'));
    }
    public function login(LoginRequest $request)
    {
        $token = $request->authenticate();

        return ApiResponse::successResponse(LoginResource::make($token), __('Successfully generate token'));
    }
    public function logout()
    {
        Auth::logout();
        return ApiResponse::successResponse(message: __('Successfully logged out'));

    }

    public function refresh()
    {
        return ApiResponse::successResponse(LoginResource::make(Auth::refresh()), __('Successfully generate token'));

    }
}
