<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class VerifyEmailConfirmed
{
    use \App\Json\AuthJson;

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
                return response()->json($this->failureLogin(), 400);
            }
        }
        return $next($request);
    }
}
