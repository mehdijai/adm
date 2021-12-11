<?php

namespace App\QueryFilters;

use Closure;

class Sort
{
    public function handle($request, Closure $next)
    {

        if(!request()->has('sort') || request('sort') == ''){
            return $next($request);
        }

        $builder = $next($request);
        
        return $this->applySort($builder);
    }

    protected function applySort($builder)
    {
        $sort =  explode('-',request('sort'));
        return $builder->orderBy($sort[0], $sort[1]);
    }
}