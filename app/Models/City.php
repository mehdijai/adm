<?php

namespace App\Models;

use App\Models\City;
use App\Models\Agence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'city',
        'secteur'
    ];
    
    public function agences(): HasMany
    {
        return $this->hasMany(Agence::class, 'city_id', 'id');
    }

    public static function getCitiesGrouped()
    {

        $allCities = City::all()->toArray();

        $cities = array();

        foreach ($allCities as $key => $item) {
            
            $has_vehs = false;

            $agences = Agence::where('city_id', $item['id'])->get();
            
            foreach($agences as $agence){

                if($agence->vehicules()->count() != 0){

                    if(!$has_vehs){
                        $has_vehs = true;
                    }
                }
            }

            if($has_vehs){
                $cities[$item['city']][$item['id']] = $item;
            }
            
        }

        ksort($cities, SORT_NUMERIC);

        return $cities;
    }
}
