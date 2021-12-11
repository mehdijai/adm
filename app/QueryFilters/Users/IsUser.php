<?php

namespace App\QueryFilters\Users;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    public function handle($request, Closure $next)
    {
        return $next($request->where('role_id', 1));
    }
}