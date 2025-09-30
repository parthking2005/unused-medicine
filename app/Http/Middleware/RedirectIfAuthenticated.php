<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect('/admin/dashboard');
                }
                break;
            case 'manager':
                if (Auth::guard($guard)->check()) {
                    return redirect('/ngo/manager');
                }
                break;
            case 'pickupman':
                if (Auth::guard($guard)->check()) {
                    return redirect('/ngo/pickupman');
                }
                break;
            case 'verifier':
                if (Auth::guard($guard)->check()) {
                    return redirect('/ngo/verifier');
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/profile');
                }
                break;
        }

        return $next($request);
    }
}