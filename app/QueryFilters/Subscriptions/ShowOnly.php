<?php

namespace App\QueryFilters\Subscriptions;

use Closure;

class ShowOnly
{

    public function handle($request, Closure $next)
    {

        if(!request()->has('show-only')){
            return $next($request);
        }

        $builder = $next($request);

        switch(request('show-only')){
            case 'active': 

                return $builder->where('active', true);

            break;

            case 'expired': 

                return $builder->where('expired', true);

            break;

            case 'pending': 

                return $builder->where('active', false)->where('expired', false);

            break;

            default: 

                return $builder;

            break;
        }
    }
}