<?php

namespace App\Http\Middleware\Packages;

use App\Models\PackagesModel;
use Closure;

class BasicPackage
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
        $package =PackagesModel::where('pak_id','=',1)->first();
        if($package->pak_name == 'Basic' || $package->pak_name == 'Advance' || $package->pak_name == 'Premium'){
            return $next($request);
        }
        return redirect()->route('home')->with('fail', 'Contact Softagics for BUY these Modules');
        return $next($request);
    }
}
