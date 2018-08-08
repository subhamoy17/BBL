<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateTrainers
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
      //If request does not comes from logged in customer then he shall be redirected to customer login page
      if(!Auth::guard()->check()) {
           return redirect('/trainer-login');
       } 
      return $next($request);
    }
}
