<?php

namespace App\Http\Middleware;
use DB;
use Closure;
use Illuminate\Http\Request;

class authentication
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
        $check =  DB::table('activation')->where('url', '=', url('/'))->Where('status', '=', '1' )->count();
        if ($check == 0 ) {
            return  redirect('dashboard');
        }
         
        return $next($request);
    }
}
