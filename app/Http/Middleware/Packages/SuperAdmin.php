<?php

namespace App\Http\Middleware\Packages;

use App\User;
use Closure;
use Auth;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = Auth::user();
        $user =User::where('user_id','=',$auth->user_id)->first();
        if($user->user_type == 'Master'){
            return $next($request);
        }
        return redirect()->route('home')->with('fail', 'You are not eligible for this');

    }
}
