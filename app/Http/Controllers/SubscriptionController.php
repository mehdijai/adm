<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehicule;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Notifications\User\NewSubs;
use App\Notifications\User\SubSoon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\User\SubExpired;

class SubscriptionController extends Controller
{
    
    public function subscribe(Request $request)
    {
        if(!$request->vehsids){
            return redirect()->back()->withErrors(['msg' => "Vous devez séléctionner au moin une voiture!"]);
        }

        $lastSub = Subscription::where('user_id', Auth::user()->id)->where('expired', false)->first();

        if($lastSub){
            return redirect()->back()->withErrors(['msg' => "Vous avez déjà un plan en cours ou en attent!"]);     
        }

        $new_subs = Subscription::create([
            'user_id' => Auth::user()->id, 
            'plan_id' => (int)$request->plan_id, 
            'active' => false, 
            'expired' => false, 
            'vehicules_ids' => $request->vehsids, 
            'periode' => (int)$request->periode, 
            'montant' => (double)$request->montant, 
        ]);

        $new_subs->notify(new NewSubs());

        return redirect()->route('premium.index');
    }
}
