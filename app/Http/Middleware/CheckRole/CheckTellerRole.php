<?php

namespace App\Http\Middleware\CheckRole;

use App\Models\EmployeeModel;
use Closure;

class CheckTellerRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->user_role_id!=config('global_variables.teller_account_id'))
        {
            return redirect()->route('index');
        }

        if ($request->user()->user_login_status == 'DISABLE') {
            return redirect()->route('logout');
        }

        return $next($request);
    }
}
