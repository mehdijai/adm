<?php

namespace App\Models;

use App\Models\Pics;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pics extends Model
{
    use HasFactory;

    protected $table = "pics";
    protected $fillable = ['image_path', 'is_thumbnail', 'vehicule_id'];

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id', 'id');
    }

    public static function upload($file, $vehicule_id, $user_id=null, $user_name=null)
    {

        if($user_id == null){
            $user_id = Auth::user()->id;
        }

        if($user_name == null){
            $user_name = Auth::user()->name;
        }

        $userid = str_replace(' ', '_', strtolower($user_name) . $user_id);
        $paths = [];

        $fileName = $userid . rand(111111, 999999) . '-' . time();
        $fileExtension = $file->getClientOriginalExtension();
        $fileNameFull = $fileName . '.' . $fileExtension;
        $imageDirctory = 'public/' . $userid . '/' . 'vehicules/' . $vehicule_id .'/images';
        $path = $file->storeAs($imageDirctory, $fileNameFull);

        $image = str_replace('public', 'storage', $path);

        $img = Image::make($image);
        $img->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($image);

        return '/' . $image;
    }

    public static function deleteImage($path){
        $file_path = str_replace('storage', 'public', $path);
        return Storage::delete($file_path);
    }

    public static function changeDirectory($veh_id, $marque, $gamme)
    {
        $folderID = $marque . '_' . $gamme . '_' . $veh_id;
        $pics = Pics::where('vehicule_id', $veh_id)->get();

        $moved = false;

        foreach ($pics as $pic) {
            $filePath = $pic->image_path;
            $pathArr = explode('/', $filePath);
            $file = array_pop($pathArr);
            $newPath = str_replace('/'.$file, "", $filePath);
            $newPath = str_replace('storage', 'public', $newPath);
            $oldPath = $newPath;
            $newPath = str_replace($pathArr[3], $folderID, $newPath);

            if(!$moved){
                Storage::move($oldPath, $newPath);
                $directory = str_replace('/images', '', $oldPath);
                Storage::deleteDirectory($directory);

                $moved = true;
            }
            
            $pic->image_path = str_replace($pathArr[3], $folderID, $pic->image_path);
            $pic->save();
        }

    }
}
