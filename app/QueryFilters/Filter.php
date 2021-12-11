<?php

namespace App\QueryFilters;

use Closure;

abstract class Filter
{
    public function handle($request, Closure $next)
    {

        if(!request()->has('search')){
            return $next($request);
        }

        $builder = $next($request);
        
        return $this->applyFilter($builder);
    }

    protected abstract function applyFilter($builder);
}