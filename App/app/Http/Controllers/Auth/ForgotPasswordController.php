<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailPasswordForgot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * パスワード更新メールを送信
     *
     * @param Request $request
     * @return User
     */
    public function sendPasswordResetMail(Request $request) {
        // メールアドレスからユーザーを取得
        $user = User::where('email', $request->input('email'))->first();

        // パスワード更新メールを送信
        $email = new EmailPasswordForgot($user);
        Mail::to($user->email)->send($email);

        return $user;
    }
}
