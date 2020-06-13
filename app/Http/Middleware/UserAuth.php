<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserAuth
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

       if($user && $user->UserRole_id != 1) {
           Auth::logout();
            return redirect('admin/login');
       }

        return $next($request);
    }
}
