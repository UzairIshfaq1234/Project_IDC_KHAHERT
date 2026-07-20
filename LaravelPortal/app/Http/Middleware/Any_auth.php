<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Any_auth
{
    /**
     * Allow any authenticated portal role (Admin, LT or Pathologist).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('Admin_Auth_Session') || session()->has('LT_Auth_Session') || session()->has('Path_Auth_Session')) {
            return $next($request);
        }

        return redirect('/');
    }
}
