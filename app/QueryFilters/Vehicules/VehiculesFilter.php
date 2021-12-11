<?php

namespace App\QueryFilters\Vehicules;

use App\QueryFilters\Filter;
use Illuminate\Support\Facades\Auth;

class VehiculesFilter extends Filter
{

    protected function applyFilter($builder)
    {
        $search = request('search');

        return $builder->join('agences', 'agences.id', '=', 'vehicules.agence_id')
                ->join('users', 'users.id', '=', 'agences.user_id')
                ->join('marques', 'marques.id', '=', 'vehicules.marque_id')
                ->join('cities', 'cities.id', '=', 'agences.city_id')
                ->select('users.cin', 'vehicules.*', 'agences.*', 'marques.*', 'cities.*')
                ->where('type', 'LIKE', "%{$search}%")
                ->orWhere('matricule', 'LIKE', "%{$search}%")
                ->orWhere('cin', 'LIKE', "%{$search}%")
                ->orWhere('marque', 'LIKE', "%{$search}%")
                ->orWhere('gamme', 'LIKE', "%{$search}%")
                ->orWhere('city', 'LIKE', "%{$search}%")
                ->orWhere('secteur', 'LIKE', "%{$search}%")
                ->select('vehicules.*');
    }
}