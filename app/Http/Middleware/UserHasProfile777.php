<?php

namespace App\Http\Middleware;

use Closure;

class UserHasProfile777
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
        dd($request);
        $user = $request->user();
        

        return abort(404);
    }
}
