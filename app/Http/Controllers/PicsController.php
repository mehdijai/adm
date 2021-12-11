<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PicsController extends Controller
{
    public function upload(Request $request)
    {

        $userid = str_replace(' ', '_', strtolower(Auth::user()->name) . Auth::user()->id);
        $paths = [];
        $files = $request->file('files');

        foreach ($files as $file) {
            
            $fileName = $userid . rand(111111, 999999) . '-' . time();
            $fileExtension = $file->getClientOriginalExtension();
            $fileNameFull = $fileName . '.' . $fileExtension;
            $imageDirctory = 'vehicules/images';
            $path = $file->storeAs($imageDirctory, $fileNameFull);

            array_push($paths, 'storage/' . $path);
        }
    }

    public function saveFiles(Request $request)
    {
        /* Store $getFileExt name in DATABASE from HERE */
    
        // Pics::create([
        //     'image_path' => storage_path('vehicules/images') . '/' .$imageName,
        //     'is_thumbnail' => $request->is_thumbnail,
        //     'vehicule_id' => $request->vehicule_id
        // ]);
    }
}
