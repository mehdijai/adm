<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($role == 'agence' && auth()->user()->role_id != 1) {
            return redirect()->route('admin.index');
        }

        if ($role == 'admin' && auth()->user()->role_id != 2) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
