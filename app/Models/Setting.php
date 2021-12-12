<?php

namespace App\Models;

use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    
    protected $table = 'settings';

    protected $fillable = [
        'name', 'data'
    ];

    public static function getProvider()
    {
        $provider = Setting::where('name', 'provider')->first();
        $providerData = json_decode($provider->data);

        $decrypted = [
            'name' => Crypt::decryptString($providerData->name),
            'bank' => Crypt::decryptString($providerData->bank),
            'rib' => Crypt::decryptString($providerData->rib),
        ];

        return $decrypted;
    }

    public static function updateProvider(Request $request)
    {
        $provider = json_encode([
            'name' => Crypt::encryptString($request->name),
            'bank' => Crypt::encryptString($request->bank),
            'rib' => Crypt::encryptString($request->rib)
        ]);

        Setting::where('name', 'provider')->update(['data' => $provider]);
    }

    public static function getContact(array $names = [])
    {
        $contact_data = Setting::where('name', 'contact')->first();
        $json = (array) json_decode($contact_data->data);
        $data = [];

        if(count($names) == 0){
            $data = $json;
        }else{
            foreach ($names as $name) {
                if(array_key_exists($name, $json)){
                    $data[$name] = $json[$name];
                }
            }
        }

        return $data;
    }

    public static function externalTags()
    {
        $tags = Setting::where('name', 'tags')->first();

        return $tags->data;
    }
    
}
