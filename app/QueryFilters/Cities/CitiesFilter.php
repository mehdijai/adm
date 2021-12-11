<?php

namespace App\QueryFilters\Cities;

use App\QueryFilters\Filter;

class CitiesFilter extends Filter
{

    protected function applyFilter($builder)
    {
        $search = request('search');

        return $builder->where('secteur', 'LIKE', "%{$search}%")
                ->orWhere('city', 'LIKE', "%{$search}%");
    }
}