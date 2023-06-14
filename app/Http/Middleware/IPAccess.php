<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Ip;
use Illuminate\Http\Request;

class IPAccess
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = Ip::where(['ip' => $request->ip(),'active' => true])->first();
        if(!$ip){
            abort(404);
        }
        return $next($request);

    }
}
