<?php

namespace App\Http\Middleware;

use App\Models\Role\Role;
use Closure;
use Auth;

class SecureRoutes
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
        $user = Auth::user();
        $role = Role::find($user->role_id);
        if($role) {
            return $next($request);
        }
        return redirect()->back();
    }
}
