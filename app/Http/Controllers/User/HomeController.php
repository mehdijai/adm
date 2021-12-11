<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\Agence;
use App\Models\Marque;
use App\Models\Setting;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\QueryFilters\Guest\FilterVehicules;

class HomeController extends Controller
{

    public function index()
    {
        /* Home Page */
        $types = (array)json_decode(Setting::where('name', 'types')->select('data')->firstOrFail()->data);
        $cities = City::getCitiesGrouped();
        $contacts = Setting::getContact(['whatsapp_link', 'facebook_link', 'instagram_link', 'telegram_link']);
        
        return view('users.home')->with([
            'cities' => $cities,
            'types' => $types,
            'contacts' => $contacts,
        ]);
    }

    public function getOptions()
    {
        $opts = [];
        $tmp_opts = [];

        $vhc = Vehicule::select("options")->get();

        foreach ($vhc as $v) {
            $tmp_opts = (array)json_decode($v->options); 

            foreach ($tmp_opts as $opt) {
                array_push($opts, $opt);
            }            
        }

        return array_unique($opts);
    }

    public function vehicules()
    {
        /* setup filter section data */

        $types = (array)json_decode(Setting::where('name', 'types')->select('data')->firstOrFail()->data);
        $cities = City::getCitiesGrouped();
        $marques = Marque::getMarquesGrouped();
        $asss = (array)json_decode(Setting::where('name', 'assurances')->select('data')->firstOrFail()->data);
        $bdvs = (array)json_decode(Setting::where('name', 'boite_de_vitesse')->select('data')->firstOrFail()->data);
        $carbs = (array)json_decode(Setting::where('name', 'carbs')->select('data')->firstOrFail()->data);

        $prix_min = Vehicule::min('prix');
        $prix_max = Vehicule::max('prix');

        $options = $this->getOptions();

        /* Filter vehicules */
        $vehicules = app(Pipeline::class)
            ->send(Vehicule::query())
            ->through([
                \App\QueryFilters\Guest\FilterVehicules::class,
            ])
            ->thenReturn()
            ->orderBy('score', 'desc')
            ->with('agence', 'agence.city', 'marque', 'pics')
            ->latest()
            ->paginate(24);

        return view('users.vehicules')
        ->with([
            'vehicules' => $vehicules,
            'types' => $types,
            'cities' => $cities,
            'marques' => $marques,
            'asss' => $asss,
            'bdvs' => $bdvs,
            'carbs' => $carbs,
            'prix_min' => $prix_min,
            'prix_max' => $prix_max,
            'options' => $options,
        ]);
    }

    public function vehicule($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        
        return view('users.vehicule')
        ->with([
            'vehicule' => $vehicule,
        ]);
    }

    public function agence($id)
    {
        $agence = Agence::findOrFail($id);
        $vehicules = $agence->vehicules()->getEager();
        $marques = [];
        $gammes = [];
        $types = [];
        $firstType = '';

        foreach ($vehicules as $veh) {
            $marque = $veh->marque()->getEager()[0];
            array_push($marques, $marque->marque);
            array_push($gammes, $marque->gamme);

            if($firstType == ""){
                $firstType = $veh->type;
            }

            array_push($types, $veh->type);
        }

        $marques = implode(", ", $marques);
        $gammes = implode(", ", $gammes);
        $city = $agence->city()->getEager()[0]->city;
        $secteur = $agence->city()->getEager()[0]->secteur;

        if (in_array($firstType, $types, true)) {
            $description = "Agence de location des " . $firstType . " basé à " . $city . " " . $secteur;
        }else{
            $description = "Agence de location des voitures et minibus basé à " . $city . " " . $secteur;
        }
        
        $keywords = $marques . ", " . $gammes . ", " . $city . ", " . $secteur;

        return view('users.agence')->with([
            'agence' => $agence,
            "keywords" => $keywords,
            "description" => $description,
        ]);
    }


}
