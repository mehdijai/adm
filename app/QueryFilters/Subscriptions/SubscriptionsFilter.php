<?php

namespace App\QueryFilters\Subscriptions;

use App\QueryFilters\Filter;
use Illuminate\Support\Facades\Auth;

class SubscriptionsFilter extends Filter
{

    protected function applyFilter($builder)
    {
        $search = request('search');

        return $builder
                ->join('users', 'subscriptions.user_id', '=', 'users.id')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->join('agences', 'agences.user_id', '=', 'users.id')
                ->join('vehicules', 'vehicules.agence_id', '=', 'agences.id')
                ->where('users.email', 'LIKE', "%{$search}%")
                ->orWhere('agences.tel', 'LIKE', "%{$search}%")
                ->orWhere('plans.name', 'LIKE', "%{$search}%")
                ->orWhere('vehicules.matricule', 'LIKE', "%{$search}%")
                ->select('subscriptions.*');
    }
}