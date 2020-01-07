<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfAdministrator
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
        $user = $request->user();
        if($user) {
            if($user->is_admin)
                return $next($request);
        }

        return abort(404);
    }
}
