<?php

namespace Modules\Auth\App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Http\Requests\API\LoginRequest;
use Modules\Auth\App\Http\Requests\API\RegisterRequest;
use Modules\Auth\App\Http\resources\API\LoginResource;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Generate JWT token
        $token = auth('api')->login($user);
        return ApiResponse::successResponse(LoginResource::make(['token'=>$token]), __('Successfully create user'),code: Response::HTTP_CREATED);
    }
    public function login(LoginRequest $request)
    {
        $token = $request->authenticate();

        return ApiResponse::successResponse(LoginResource::make(['token'=>$token]), __('Successfully generate token'));
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
