<?php

namespace App\Http\Middleware;

use Closure;

class SessionTimeOut
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

//    use CacheQueryResults;

    public function handle($request, Closure $next)
    {
//        // session()->forget('lastActivityTime');
//        dd(!session()->has('lastActivityTime'),session(['lastActivityTime' => now()]), session('lastActivityTime')->date);
//
//        if (!session()->has('lastActivityTime')) {
//            session(['lastActivityTime' => now()]);
//        }
//
//        // dd(
//        //     session('lastActivityTime')->format('Y-M-jS h:i:s A'),
//        //     now()->diffInMinutes(session('lastActivityTime')),
//        //     now()->diffInMinutes(session('lastActivityTime')) >= config('session.lifetime')
//        // );
//
//        if (now()->diffInMinutes(session('lastActivityTime')) >= (2) ) {  // also you can this value in your config file and use here
//
//            dd(12);
//            if (auth()->check() && auth()->id() > 1) {
//
//
//                $user = auth()->user();
//                auth()->logout();
//
//                $user->update(['user_web_status' => "offline"]);
//                $this->reCacheAllUsersData();
//
//                session()->forget('lastActivityTime');
//
//                return redirect(route('users.login'));
//            }
//
//        }
//
//        session(['lastActivityTime' => now()]);
//
//        return $next($request);

    }
}
