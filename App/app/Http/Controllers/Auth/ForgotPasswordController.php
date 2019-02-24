<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailPasswordForgot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendPasswordResetMail(Request $request) {
        $user = User::where('email', $request->input('email'))->first();

        $email = new EmailPasswordForgot($user);
        Mail::to($user->email)->send($email);

        return $user;
    }

    public function verifyPasswordResetMail(Request $request) {
        $email_token = $request->input('token');
        // 使用可能なトークンか
        if ( !User::where('email_verify_token',$email_token)->exists() ) {
            return array(
                'result'  => 'error',
                'message' => '無効なトークンです。',
                'user'    => null,
            );
        } else {
            $user = User::where('email_verify_token', $email_token)->first();
            return array(
                'result'  => 'success',
                'message' => '有効なトークンです。',
                'user'    => $user,
            );
        }
    }
}
