<?php

namespace App\Http\Controllers\Agence;

use App\Models\Pics;
use App\Models\Agence;
use App\Models\Marque;
use App\Models\Setting;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehsController extends Controller
{
    public $types = [];
    public $asss = [];
    public $bdvs = [];
    public $carbs = [];

    public static function view($id)
    {
        $car = Vehicule::findOrFail($id);

        return view('agence.view')
        ->with([
            'car' => $car
        ]);
    }



    public function create()
    {
        $this->setup_vars();

        return view('agence.create')->with([
            'form_type' => route('vehs.store'),
            'types' => $this->types,
            'asss' => $this->asss,
            'bdvs' => $this->bdvs,
            'carbs' => $this->carbs,
        ]);
    }

    public function store(Request $req)
    {
        $duplicated = Vehicule::where('matricule', str_replace(' ', '_', $req->matricule))->count();

        if($duplicated > 0){
            return response()->json(['error' => 'Cette matricule déjà existe dans notre base de donnée! Merci de le vérifier, ou contactez-nous si le problème reste présent.'], 200);
        }

        /* Search Marque or create one */
        $marque = Marque::firstOrCreate([
            'marque' => $req->marque, 'gamme' => $req->gamme
        ]);

        $agence = Auth::user()->agence()->getEager()[0];        

        $vehicule = Vehicule::create([
            'agence_id' => $agence->id,
            'marque_id' => $marque->id,
            'type' => $req->VehiculeClass,
            'matricule' => str_replace(' ', '_', $req->matricule),
            'prix' => $req->prix,
            'assurance' => $req->assurance,
            'carb' => $req->carb,
            'boite_de_vitesse' => $req->bdv,
            'description' => $req->desc,
            'options' => $req->options,
            'score' => 0,
            'vip' => false,
        ]);

        /* Save Images */
        $files = $req->file('files');

        $isThumbs = $req->isthumb;

        for ($i=0; $i < count($files); $i++) { 

            $folderID = $req->marque . '_' . $req->gamme . '_' . $vehicule->id;
            $path = Pics::upload($files[$i], $folderID);
            $bv = false;

            if($isThumbs[$i] == "true"){
                $bv = true;
            }else{
                $bv = false;
            }

            Pics::create([
                'image_path' => $path, 
                'is_thumbnail' => $bv,
                'vehicule_id' => $vehicule->id
            ]);

        }

        return response()->json(["redirect" => route('dashboard')], 200);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $vehicule = Vehicule::find($id);
        $marques = $vehicule->marque()->getEager()[0];

        if(!$vehicule){
            return redirect()->route('dashboard');
        }

        /* Delete images directory  */
        $folderID = $marques->marque . '_' . $marques->gamme . '_' . $vehicule->id;
        $directory = "public/vehicules/" . $folderID;

        Storage::deleteDirectory($directory);

        /* Remove vehicule */
        $vehicule->delete();

        return redirect()->route('dashboard');
    }

    public static function update(Request $request)
    {
        $veh = Vehicule::find($request->id);
        $marque = $veh->marque()->getEager()[0];

        if($marque->marque != $request->marque || $marque->gamme != $request->gamme){
            $new_marque = Marque::firstOrCreate([
                'marque' => $request->marque, 'gamme' => $request->gamme
            ]);

            $veh->marque_id = $new_marque->id;
        }

        if($veh->type != $request->VehiculeClass){
            $veh->type = $request->VehiculeClass;
        }
        if($veh->prix != $request->prix){
            $veh->prix = $request->prix;
        }
        if($veh->assurance != $request->assurance){
            $veh->assurance = $request->assurance;
        }
        if($veh->carb != $request->carb){
            $veh->carb = $request->carb;
        }
        if($veh->boite_de_vitesse != $request->bdv){
            $veh->boite_de_vitesse = $request->bdv;
        }
        if($veh->description != $request->desc){
            $veh->description = $request->desc;
        }
        if($veh->options != $request->options){
            $veh->options = $request->options;
        }

        if($request->deleted_images){
            foreach($request->deleted_images as $di){

                Pics::where('image_path', $di)->delete();
                Pics::deleteImage($di);
            }
        }

        if($request->thumb_type == 'existed'){
            $pics = Pics::where('vehicule_id', $request->id)->update(['is_thumbnail' => 0]);
            $pics = Pics::where('vehicule_id', $request->id)->where('image_path', $request->thumb)->update(['is_thumbnail' => 1]);
        }

        if($request->file('files')){
            foreach ($request->file('files') as $file) {
                $folderID = $request->marque . '_' . $request->gamme . '_' . $request->id;
                $path = Pics::upload($file, $folderID);

                if($request->thumb_type == 'new' && $request->thumb == array_search($file, $request->file('files'))){
                    $bv = true;
                }else{
                    $bv = false;
                }

                Pics::create([
                    'image_path' => $path, 
                    'is_thumbnail' => $bv,
                    'vehicule_id' => $request->id
                ]);
            }
        }

        $veh->save();

        return response()->json(["redirect" => route('dashboard')], 200);
    }

    public function edit($id)
    {
        $this->setup_vars();

        $vehicule = Vehicule::find($id);
        $marque = $vehicule->marque()->getEager()[0];
        $agence = Auth::user()->agence()->getEager()[0];        
        
        $pics = $vehicule->pics()->getEager();
        $images = [];
        
        foreach ($pics as $pic) {
            array_push($images, [
                "url" => $pic->image_path,
                "is_thumbnail" => $pic->is_thumbnail
            ]);
        }

        $data = [
            'form_type' => route('vehs.update'),
            'id' => $id,
            'types' => $this->types,
            'asss' => $this->asss,
            'bdvs' => $this->bdvs,
            'carbs' => $this->carbs,
            'agence_id' => $agence->id,
            'vehicule_id' => $vehicule->id,
            'marque' => $marque->marque,
            'gamme' => $marque->gamme,
            'VehiculeClass' => $vehicule->type,
            'matricule' => str_replace('_', ' ', $vehicule->matricule),
            'prix' => $vehicule->prix,
            'assurance' => $vehicule->assurance,
            'carb' => $vehicule->carb,
            'bdv' => $vehicule->boite_de_vitesse,
            'desc' => $vehicule->description,
            'options' => $vehicule->options,
            'images' => json_encode($images),
        ];

        return view('agence.update')->with($data);
    }

    /* --------------- */

    public function setup_vars()
    {
        $this->types = (array)json_decode(Setting::where('name', 'types')->select('data')->firstOrFail()->data);
        $this->asss = (array)json_decode(Setting::where('name', 'assurances')->select('data')->firstOrFail()->data);
        $this->bdvs = (array)json_decode(Setting::where('name', 'boite_de_vitesse')->select('data')->firstOrFail()->data);
        $this->carbs = (array)json_decode(Setting::where('name', 'carbs')->select('data')->firstOrFail()->data);
    }
}
