<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // dd($request->rol);
        if (Auth::guard($request->rol)->check()) {
            return redirect('/home');
        }

        // if (Auth::guard('colaboradores')->check()) {
        //     return redirect('/home');
        // }

        return $next($request);
    }
}
