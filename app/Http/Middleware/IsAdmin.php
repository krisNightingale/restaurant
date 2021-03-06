<?php

namespace App\Http\Middleware;

use App\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        $permission = Permission::where('name', 'like', 'admin_permissions')->first();
        if (Auth::check() && Auth::user()->hasPermission($permission))
        {
            return $next($request);
        }
        return redirect('/');
    }
}
