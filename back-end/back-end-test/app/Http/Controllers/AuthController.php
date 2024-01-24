<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $userData = $request->only('email', 'password');

        if (Auth::attempt($userData)) {
            $token = $request->user()->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'login berhasil',
                'token' => $token,
                'token-type' => 'Bearer'
            ], 200);
        }

        return response()->json(['message' => 'Email dan Password salah'], 401);
    }
}
