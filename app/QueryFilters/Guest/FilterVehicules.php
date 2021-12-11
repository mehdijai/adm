<?php

namespace App\QueryFilters\Guest;

use Closure;

class FilterVehicules
{

    public function handle($request, Closure $next)
    {
        
        if(!request()->hasAny(['type','ville', 'marque', 'assurance', 'carb', 'bdv', 'prix_min', 'prix_max', 'options'])){
            
            return $next($request);
        }

        $builder = $next($request);
        
        return $builder->join('agences', 'agences.id', '=', 'vehicules.agence_id')
            ->select('vehicules.*', 'agences.city_id')
            ->where(function ($query) use ($request) {

                if(request()->has('ville') && request('ville') != ''){
                    $query->where('agences.city_id', request('ville'));
                }
                if(request()->has('type') && request('type') != ''){
                    $query->where('type', request('type'));
                }
                if(request()->has('marque') && request('marque') != ''){
                    $query->where('marque_id', request('marque'));
                }
                if(request()->has('assurance') && request('assurance') != ''){
                    $query->where('assurance', request('assurance'));
                }
                if(request()->has('carb') && request('carb') != ''){
                    $query->where('carb', request('carb'));
                }
                if(request()->has('bdv') && request('bdv') != ''){
                    $query->where('boite_de_vitesse', request('bdv'));
                }
                if(request()->has('prix_min') && request('prix_min') != ''){
                    $query->where('prix', '>=', request('prix_min'));
                }
                if(request()->has('prix_max') && request('prix_max') != ''){
                    $query->where('prix', '<=', request('prix_max'));
                }
                if(request()->has('options') && request('options') != ''){
                    $options = json_decode(request('options'));

                    foreach ($options as $opt) {
                        $query->where('options', 'LIKE', '%' . $opt . '%');
                    }
                }
            })
            ->select('vehicules.*');
    }
}