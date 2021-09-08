<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $role =  auth()->user()->role;
        if ($role == 0 ) {
            return  redirect('dashboard');
        }
       
        return $next($request);
    }
        
    
}
