<?php

namespace app\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthLogin
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
        $login = Session::get('login');
        if (!$login) {
            return redirect()->route('loginPage');
        }

        return $next($request);
    }
}
