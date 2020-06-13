<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;

class UserGuest
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

        if($user && $user->UserRole_id != 2) {
            Auth::logout();
 
            return redirect('login');
        }

        return $next($request);
    }
}
