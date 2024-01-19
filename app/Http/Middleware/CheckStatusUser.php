<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckStatusUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Если статус пользователя стал "Неактивен" выкидываем его из системы.
        if(Auth::user() && !Auth::user()->is_active) {
            Session::flush();
            Auth::logout();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
