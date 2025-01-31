<?php

namespace App\Http\Middleware;

use App\Models\DayEndModel;
use Closure;
use Illuminate\Http\Request;

class DayEnd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $dayend =DayEndModel::count();
        if($dayend > 1){
            return $next($request);
        }
        return redirect()->route('wizard.index')->with('fail', 'Complete the Wizard');
    }
}
