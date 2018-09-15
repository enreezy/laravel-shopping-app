<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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

        if(auth()->user()->role->role == 'admin'){
            return $next($request);
        }else if(auth()->user()->role->role == 'customer'){
            return redirect('/shopping');
        }

        return redirect('/');
    }
}
