<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
        ];

        $user = User::create($data);

        $token = $user->createToken($request->name)->plainTextToken;

        return response([
            'meta' => $user,
            'token' => $token,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::whereEmail($request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Invalid credential',
            ]);
        }

        $token = $user->createToken($user->name)->plainTextToken;

        return response([
            'meta' => $user,
            'token' => $token,
        ]);
    }
}