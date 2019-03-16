<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class VerifyEmailConfirmed
{
    use \App\Json\AuthFailJson;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::where('email', '=', $request->input('email'))->first();
        if($user){
            if(!$user->email_verified){
                return response()->json($this->failLogin(), 400);
            }
        }
        return $next($request);
    }
}
