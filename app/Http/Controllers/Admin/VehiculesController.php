<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pics;
use App\Models\User;
use App\Models\Marque;
use App\Models\Setting;
use App\Models\Vehicule;
use App\QueryFilters\Sort;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\QueryFilters\Vehicules\VehiculesFilter;

class VehiculesController extends Controller
{
    public function index()
    {
        $vehicules = app(Pipeline::class)
            ->send(Vehicule::query())
            ->through([
                \App\QueryFilters\Vehicules\VehiculesFilter::class,
                \App\QueryFilters\Sort::class,
            ])
            ->thenReturn()
            ->latest()
            ->with('agence.user', 'agence.city', 'marque')
            ->paginate(25);

        return view('admins.vehicules.index')->with(['vehicules' => $vehicules]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric'],
        ]);

        try{
            
            $id = $request->id;
            $vehicule = Vehicule::find($id);
            $marques = $vehicule->marque()->getEager()[0];

            if(!$vehicule){
                return redirect()->route('admin.vehicules.index');
            }

            /* Delete images directory  */
            $folderID = $marques->marque . '_' . $marques->gamme . '_' . $vehicule->id;
            $directory = "public/vehicules/" . $folderID;

            Storage::deleteDirectory($directory);

            /* Remove vehicule */
            $vehicule->delete();

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return redirect()->route('admin.vehicules.index');
        
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
            $pics = Pics::where('vehicule_id', $request->id)->where('is_thumbnail', 1)->update(['is_thumbnail' => 0]);

            $pics = Pics::where('vehicule_id', $request->id)->where('image_path', $request->thumb)->first();
            $pics->update(['is_thumbnail' => 1]);
        }

        $user = $veh->agence()->getEager()[0]->user()->getEager()[0];

        if($request->file('files')){
            foreach ($request->file('files') as $file) {
                $folderID = $request->marque . '_' . $request->gamme . '_' . $request->id;
                $path = Pics::upload($file, $folderID, $user->id, $user->name);

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

        return response()->json(["redirect" => route('admin.vehicules.index')], 200);
    }

    public $types = [];
    public $asss = [];
    public $bdvs = [];
    public $carbs = [];

    public function edit($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $this->setup_vars();

        $vehicule = Vehicule::findOrFail($id);
        $marque = $vehicule->marque()->getEager()[0];
        $agence = $vehicule->agence()->getEager()[0]; 
        
        $pics = $vehicule->pics()->getEager();
        $images = [];
        
        foreach ($pics as $pic) {
            array_push($images, [
                "url" => $pic->image_path,
                "is_thumbnail" => $pic->is_thumbnail
            ]);
        }

        $data = [
            'form_type' => route('admin.vehicules.update'),
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

        return view('admins.vehicules.update')->with($data);
    }

    /* --------------- */

    public function setup_vars()
    {
        $this->types = (array)json_decode(Setting::where('name', 'types')->select('data')->firstOrFail()->data);
        $this->asss = (array)json_decode(Setting::where('name', 'assurances')->select('data')->firstOrFail()->data);
        $this->bdvs = (array)json_decode(Setting::where('name', 'boite_de_vitesse')->select('data')->firstOrFail()->data);
        $this->carbs = (array)json_decode(Setting::where('name', 'carbs')->select('data')->firstOrFail()->data);
    }

    
    public function create($id)
    {
        $this->setup_vars();

        return view('admins.vehicules.create')->with([
            'form_type' => route('admin.vehicules.store'),
            'types' => $this->types,
            'asss' => $this->asss,
            'bdvs' => $this->bdvs,
            'carbs' => $this->carbs,
            'user_id' => $id,
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

        $user = User::find($req->user_id);

        $agence = $user->agence()->getEager()[0];        

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
            $path = Pics::upload($files[$i], $folderID, $user->id, $user->name);
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

        return response()->json(["redirect" => route('admin.vehicules.index')], 200);
    }
}
