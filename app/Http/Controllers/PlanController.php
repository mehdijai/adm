<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Notifications\User\SubSoon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\User\SubExpired;
use Illuminate\Notifications\Notification;

class PlanController extends Controller
{
    public $subscription = null;
    public $currentPlan_expirationDate = null;
    public $expiration = 0;

    public function index()
    {
        $status = $this->expirationCheck();
        
        return view('agence.premium.index')->with([
            'plans' => Plan::all(),
            'status' => $status,
            'subscription' => $this->subscription,
            'contact_data' => Setting::getContact(['whatsapp_number', 'email_premium']),
            'expiration_date' => $this->currentPlan_expirationDate,
            'expiration' => $this->expiration,
        ]);
    }

    public function view($id)
    {
        $plan = Plan::find($id);

        return view('agence.premium.purchase')->with([
            "plan" => $plan,
            "contacts" => Setting::getContact(['whatsapp_link', 'email_premium', 'whatsapp_number']),
            "provider" => Setting::getProvider(),
            "vehicules" => Auth::user()->agence()->getEager()[0]->vehicules()->getEager()
        ]);
    }

    public function checkSubscription()
    {
        $lastSub = Subscription::where('user_id', Auth::user()->id)->first();

        if($lastSub){
            if($lastSub->expired){
                return 'expired_mode';
            }

            if($lastSub->active){

                $this->subscription = $lastSub;
                $this->currentPlan_expirationDate = Carbon::parse($lastSub->activation_date)->addDays($lastSub->periode)->format('d/m/Y');

                return 'active_mode';
            }else{

                $this->subscription = $lastSub;
                return 'non_active_mode';
            }

        }else{
            return 'free_mode';
        }
    }

    public function expirationCheck()
    {
        /* Exist Sub */
        $lastSub = Subscription::where('user_id', Auth::user()->id)->first();

        if($lastSub){
            /* Expired? */
            if($lastSub->expired){
                /* Already Expired */
                return 'expired_mode';
            }else{
                if($lastSub->active){
                    $now = Carbon::now();
                    $expirationDate = Carbon::parse($lastSub->activation_date)->addDays($lastSub->periode);
                    $diff = $now->diffInDays($expirationDate, false);
                    
                    /* EXPIRED */
                    if($diff <= 0){
                        return 'expired_mode';
                    }else{
                        
                        if($lastSub->periode > 7 && $diff < 3){
                            /* SOON */
                            /* Notify(soon) */
                            $this->subscription = $lastSub;
                            $this->currentPlan_expirationDate = Carbon::parse($lastSub->activation_date)->addDays($lastSub->periode)->format('d/m/Y');
                            $this->expiration = $diff;

                            return "soon_mode";
                        }else{
                            /* Active */
                            $this->subscription = $lastSub;
                            $this->currentPlan_expirationDate = Carbon::parse($lastSub->activation_date)->addDays($lastSub->periode)->format('d/m/Y');
                            return "active_mode";
                        }
                    }
                }else{
                    /* Not activated yet */
                    $this->subscription = $lastSub;
                    return 'non_active_mode';
                }
            }
        }else{
            /* Free mode */
            return 'free_mode';
        }
    }
}
