<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class CheckPermission
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
        // $User = auth()->user();
        // $User->User->UserRole->Role;
        // $CurrentRoute = Route::getCurrentRoute();
        // $Controller = $CurrentRoute->getController();
        // $ActionMethod = $CurrentRoute->getActionMethod();
        return $next($request);
    }
}
