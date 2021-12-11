<?php

namespace App\QueryFilters\Admins;

use Illuminate\Support\Facades\Auth;
use App\QueryFilters\Filter;

class AdminsFilter extends Filter
{
    protected function applyFilter($builder)
    {
        $search = request('search');

        return $builder->where(function($query) use($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('cin', 'LIKE', "%{$search}%");
                });
    }
}