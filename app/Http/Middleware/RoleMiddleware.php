<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {

        if(!auth()->user()->hasEntrance()) {

            return response()->json(false,200);
        }

        return $next($request);
    }

}
