<?php

use App\Models\City;
use App\Models\Marque;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('cities', function () {

    $cities = array();
    $secteurs = array();
    
    $allCities = City::select("city", "secteur", "id")->get();

    foreach ($allCities as $city) {
        array_push($cities, $city->city);
        array_push($secteurs, $city->secteur);
    }

    $cities = array_unique($cities);

    return response()->json([
        'cities' => $cities,
        'secteurs' => $secteurs,
    ], 200);
});

Route::get('marques', function () {

    $marques = array();
    $gammes = array();
    
    $allMarques = Marque::select("marque", "gamme", "id")->get();
    
    foreach ($allMarques as $marque) {
        array_push($marques, $marque->marque);
        array_push($gammes, $marque->gamme);
    }
    
    return response()->json([
        'marques' => array_unique($marques),
        'gammes' => array_unique($gammes),
    ], 200);
});

Route::get('options', function () {

    $opts = [];
    $tmp_opts = [];

    $vhc = Vehicule::select("options")->get();

    foreach ($vhc as $v) {
        $tmp_opts = (array)json_decode($v->options); 

        foreach ($tmp_opts as $opt) {
            array_push($opts, $opt);
        }            
    }

    return response()->json([
        'options' => array_unique($opts),
    ], 200);
});