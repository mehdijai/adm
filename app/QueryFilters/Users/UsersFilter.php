<?php

namespace App\QueryFilters\Users;

use App\QueryFilters\Filter;
use Illuminate\Support\Facades\Auth;

class UsersFilter extends Filter
{

    protected function applyFilter($builder)
    {
        $search = request('search');

        return $builder->join('agences', 'agences.user_id', '=', 'users.id')
                ->join('cities', 'agences.city_id', '=', 'cities.id')
                ->where(function($query) use($search) {
                    $query->where('users.name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('cin', 'LIKE', "%{$search}%")
                        ->orWhere('agences.name', 'LIKE', "%{$search}%")
                        ->orWhere('cities.city', 'LIKE', "%{$search}%")
                        ->orWhere('cities.secteur', 'LIKE', "%{$search}%");
                })
                ->select('users.*');
    }
}