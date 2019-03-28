<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->middleware('confirm', ['only' => 'login']);
    }

    /**
     * ログイン
     * ログイン成功時はアクセストークン、失敗時はエラーコードを返却
     *
     * @return json
     */
    public function login()
    {
        // リクエスト内容をもとにログイン
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * ログインユーザーの取得
     *
     * @return json
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * トークン付きjsonを返却
     *
     * @return json
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("api")->factory()->getTTL()
        ]);
    }
}
