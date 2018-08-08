<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticateCustomers
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
      Log::debug("request login sssssss".$request);
      //If request does not comes from logged in customer then he shall be redirected to customer login page
      if(!Auth::guard('customer')->check()) {
           return redirect('/customer-login');
       }

      return $next($request);
    }
}
