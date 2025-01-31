<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && is_null($user->session_id) && $user->user_id != 1 && $user->user_id != 2) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your session has expired.');
        }
        return $next($request);
    }
}
