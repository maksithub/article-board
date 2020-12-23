<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserParam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(empty($request->user_id)){
            if(!Auth::check()){
                abort(403, '잘못된 접근입니다.');
            }
        }
        return $next($request);
    }
}
