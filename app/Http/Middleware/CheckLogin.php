<?php

namespace app\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use app\Helpers\Main;

class CheckLogin
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
        $login = Session::get('login');
        if ($login) {
            $route_name = Main::access_menu_first();
            return redirect()->route($route_name);
        }
        return $next($request);
    }
}
