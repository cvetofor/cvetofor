<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminDebugBar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (optional(auth()->guard('twill_users')->user())->is_superadmin || (env('APP_DEBUG') && env('APP_ENV') == 'local')) {
            \Debugbar::enable();
        } else {
            \Debugbar::disable();
        }

        return $next($request);
    }
}
