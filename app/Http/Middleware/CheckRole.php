<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        $roleName = $request->user()->role->name;

        if ($roleName == 'SuperAdmin' && $role === 'admin') {
//            dd('superadmin');
            return $next($request);
        }

        if ($roleName === 'Employee' && $role === 'employee') {
//            dd('emp');
            return $next($request);
        }

        if ($roleName === 'Employee' && $role === 'all' || $roleName === 'SuperAdmin' && $role === 'all') {
//            dd('all');
            return $next($request);

        }

        abort(403);
    }
}
