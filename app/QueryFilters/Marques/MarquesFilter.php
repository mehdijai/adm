<?php

namespace App\QueryFilters\Marques;

use App\QueryFilters\Filter;

class MarquesFilter extends Filter
{

    protected function applyFilter($builder)
    {
        $search = request('search');

        return $builder->where('gamme', 'LIKE', "%{$search}%")
                ->orWhere('marque', 'LIKE', "%{$search}%");
    }
}