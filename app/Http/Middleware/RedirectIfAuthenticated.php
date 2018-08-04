<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        // switch ($guard) {
        //     case 'customer':
        //         if (Auth::guard($guard)->check()) {
        //         return redirect('customer/bbl');
        //         }
        //         break;
            
        //     default:
        //         if (Auth::guard($guard)->check()) {
        //         return redirect('/');
        //         }
        //         break;
        // }

        //If request comes from logged in admin, he will be redirected to admin's home page.
        if (Auth::guard()->check()) {
            return redirect('/trainer/home');
        }

        //If request comes from logged in customer, he will be redirected to customer's home page.
        if (Auth::guard('customer')->check()) {
            return redirect('/customer/bbl');
        }

        return $next($request);
    }
}
