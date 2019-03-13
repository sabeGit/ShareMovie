<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('confirm', ['only' => 'login']);
    }

    public function login() {
        $credentials = request(['email', 'password']);
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        return $this->respondWithToken($token);
    }

    // public function logout() {
    //     auth()->logout();
    //     return response()->json(['message' => 'ログアウトしました。']);
    // }

    public function me() {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("api")->factory()->getTTL()
        ]);
    }
}
