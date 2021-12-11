<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\Agence;
use App\Models\Marque;
use App\Models\Setting;
use App\Models\Vehicule;
use Illuminate\Support\Str;
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

        return view('users.vehicules',
        compact(
            'vehicules',
            'types',
            'cities',
            'marques',
            'asss',
            'bdvs',
            'carbs',
            'prix_min',
            'prix_max',
            'options'
        ));
    }

    public function vehicule($slug)
    {
        $vehicule = null;

        if(is_numeric($slug)){
            $vehicule = Vehicule::findOrFail($slug);
            return redirect()->route('vehicule', $vehicule->slug);
        }else{
            $vehicule = Vehicule::with('agence.city', 'agence.user', 'pics')->where('slug', $slug)->first();
        };

        if($vehicule === null){
            abort(404);
        }

        return view('users.vehicule', compact('vehicule'));
    }

    public function agence($slug)
    {
        $agence = null;

        if(is_numeric($slug)){
            $agence = Agence::findOrFail($slug);
            return redirect()->route('agence', $agence->slug);
        }else{
            $agence = Agence::where('slug', $slug)->with('user', 'city', 'vehicules.marque')->first();
        };

        if($agence === null){
            abort(404);
        }

        $marques = [];
        $gammes = [];

        $marques = $agence->vehicules->map(function($veh) {
            return $veh->marque->marque;
        });

        $gammes = $agence->vehicules->map(function($veh) {
            return $veh->marque->gamme;
        });

        $types = array_unique($agence->vehicules->map(function($veh) {
            return $veh->type;
        })->toArray());

        $marques = implode(", ", $marques->toArray());
        $gammes = implode(", ", $gammes->toArray());

        $city = $agence->city->city;
        $secteur = $agence->city->secteur;

        if (count($types) == 2) {
            $description = "Agence de location des voitures et minibus basé à " . $city . " " . $secteur;
        }else{
            $description = "Agence de location des " . array_values($types)[0] . " basé à " . $city . " " . $secteur;
        }
        
        $keywords = $marques . ", " . $gammes . ", " . $city . ", " . $secteur;

        return view('users.agence', compact('agence', 'keywords', 'description'));
    }


}
