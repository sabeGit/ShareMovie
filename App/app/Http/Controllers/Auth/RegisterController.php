<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailVerification;
use JWTAuth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verify_token' => base64_encode($data['email']),
        ]);
        $this->sendVerifyMail($user);
        return $user;
    }

    public function resendVerifyMail(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        $this->sendVerifyMail($user);
        return $user;
    }

    protected function sendVerifyMail($user) {
        $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);
    }

    public function verify(Request $request)
    {
        $email_token = $request->input('token');
        // 使用可能なトークンか
        if ( !User::where('email_verify_token',$email_token)->exists() ) {
            return array(
                'result'  => 'error',
                'message' => '無効なトークンです。'
            );
        } else {
            $user = User::where('email_verify_token', $email_token)->first();
            // 本登録済みユーザーか
            if ($user->email_verified) {
                return array(
                    'result'  => 'error',
                    'message' => 'すでに本登録されています。ログインして利用してください。'
                );
            }
            $user->email_verified = true;
            if($user->save()) {
                $token = JWTAuth::fromUser($user);
                return array(
                    'result'  => 'success',
                    'message' => 'ご本人様確認が完了しました。',
                    'user'    => $user,
                    'access_token' => $token
                );
            } else {
                return array(
                    'result'  => 'error',
                    'message' => 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。'
                );
            }
        }
    }

    protected function registered(Request $request, $user)
    {
        return $user;
    }
}
