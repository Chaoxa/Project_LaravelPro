<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Http\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissionSlug)
    {
        $user = User::find(session('userID'));

        if (!$user->hasPermission($permissionSlug)) {
            abort(401);
        }

        return $next($request);
    }
}
