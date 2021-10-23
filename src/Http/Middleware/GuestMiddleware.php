<?php

namespace Ajifatur\Campusnet\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->check() && in_array($request->user()->role_id, [role('admin'), role('manager'), role('instructor')]) && is_int(strpos($request->path(), 'login'))) {
            return redirect()->route('admin.dashboard');
        }
        elseif(Auth::guard($guard)->check() && in_array($request->user()->role_id, [role('learner')]) && is_int(strpos($request->path(), 'login'))) {
            return redirect('/');
        }

        return $next($request);
    }
}
