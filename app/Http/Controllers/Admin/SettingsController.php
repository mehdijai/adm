<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class SettingsController extends Controller
{

    public function index()
    {
        $settings = Setting::where('name', '!=', 'provider')->where('name', '!=', 'contact')->where('name', '!=', 'tags')->get();
        $settings_list = new Setting();
        $tags = Setting::where('name', 'tags')->first();
        $tags = $tags->data;

        return view('admins.settings.index', compact('tags', 'settings', 'settings_list'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'data' => ['required', 'string'],
        ]);

        $setting = Setting::where('name', $request->name)->first();
        $setting->data = $request->data;
        $setting->save();

        return redirect()->route('admin.settings.index');
        
    }

    public function contacts_update(Request $request)
    {
        $request->validate([
            'contact-name' => ['required', 'string'],
            'contact-data' => ['required', 'string'],
        ]);

        $req = $request->all();

        $contacts = Setting::getContact();
        $contacts[$req['contact-name']] = $req['contact-data'];

        Setting::where('name', 'contact')->update(['data' => json_encode($contacts)]);

        return redirect()->route('admin.settings.index');
        
    }

    public function provider_update(Request $request)
    {
        $request->validate([
            'provider-name' => ['required', 'string'],
            'provider-data' => ['required', 'string'],
        ]);

        $req = $request->all();

        $provider = Setting::getProvider();

        $provider[$req['provider-name']] = $req['provider-data'];

        $provider_enc = json_encode([
            'name' => Crypt::encryptString($provider['name']),
            'bank' => Crypt::encryptString($provider['bank']),
            'rib' => Crypt::encryptString($provider['rib'])
        ]);

        Setting::where('name', 'provider')->update(['data' => $provider_enc]);

        return redirect()->route('admin.settings.index');
        
    }

    public function tags_update(Request $request)
    {
        Setting::where('name', 'tags')->update(['data' => $request->tags]);

        return redirect()->route('admin.settings.index');
    }
}
