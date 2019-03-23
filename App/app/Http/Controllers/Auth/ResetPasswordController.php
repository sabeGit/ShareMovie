<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $email_token = $request->token;
        // 使用可能なトークンか
        if ( !User::where('email_verify_token',$email_token)->exists() ) {
            return array(
                'result'  => 'error',
                'message' => '無効なトークンです。',
                'user'    => null,
            );
        } else {
            $user = User::where('email_verify_token', $email_token)->first();
            $user->forceFill([
                'password' => bcrypt($request->password),
            ])->save();
            return response()->json($user, 200);
        }
    }
}
