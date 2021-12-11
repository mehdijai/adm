<?php

namespace App\QueryFilters\Admins;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        return $next($request->where('role_id', 2)->where('id', '!=', Auth::user()->id));
    }
}