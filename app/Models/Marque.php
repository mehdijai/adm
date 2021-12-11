<?php

namespace App\Models;

use App\Models\Marque;
use App\Models\Vehicule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marque extends Model
{
    use HasFactory;
    
    protected $table = 'marques';
    
    protected $fillable = ['marque', 'gamme'];

    public function vehicules(): HasMany
    {
        return $this->hasMany(Vehicule::class, 'marque_id', 'id');
    }

    public static function getMarquesGrouped()
    {

        $allMarques = Marque::all()->toArray();

        $marques = array();

        foreach ($allMarques as $key => $item) {

            $vehicules = Vehicule::where('marque_id', $item['id'])->count();

            if($vehicules != 0){
                $marques[$item['marque']][$item['id']] = $item;
            }
            
        }

        ksort($marques, SORT_NUMERIC);

        return $marques;
    }
}
