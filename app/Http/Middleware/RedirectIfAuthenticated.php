<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

use Illuminate\Http\Request;


class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null, ...$guards)
    {
        switch ($guard) {
            case 'admin' :
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.dashboard');
                }
                break;
            case 'master' :
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('master.dashboard');
                }
                break;
            case 'student' :
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('student.dashboard');
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('home');
                }
                break;
        }
        return $next($request);

//                 if (Auth::guard($guard)->check()) {
//                     return redirect('/home');
        //            return redirect()->back();
//                 }
//        $guards = empty($guards) ? [null] : $guards;
//
//        foreach ($guards as $guard) {
//            // dd($guard);
//            if ($guard == "master" && Auth::guard($guard)->check()) {
//                // return redirect('/admin/dashboard');
//                echo $guard;
//            }
//
//            if (Auth::guard($guard)->check()) {
//                return redirect('/home');
//            }
//        }

//        return $next($request);
    }
}
