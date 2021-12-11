<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Vehicule;
use App\Models\Subscription;
use Illuminate\Console\Command;
use App\Notifications\User\SubSoon;
use App\Notifications\User\SubExpired;
use Illuminate\Support\Facades\Log;

class checkExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expiration of subscription';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* Exist Sub */
        $lastSubs = Subscription::where('expired', false)->where('active', true)->get();

        foreach($lastSubs as $lastSub){

            $now = Carbon::now();
            $expirationDate = Carbon::parse($lastSub->activation_date)->addDays($lastSub->periode);
            $diff = $now->diffInDays($expirationDate, false);
            
            /* EXPIRED */
            if($diff <= 0){

                $lastSub->active = false;
                $lastSub->expired = true;
                $lastSub->expiration_date = $now;
                $lastSub->save();

                $ids = json_decode($lastSub->vehicules_ids);
                Vehicule::updateScore($ids, $lastSub);

                $lastSub->notify(new SubExpired());
            }else{
                
                if($lastSub->periode > 7 && $diff < 3){

                    $notifications = $lastSub->notifications()->where('data', '{"state":"soon","user_id":' . $lastSub->user_id . '}')->first();

                    if($notifications == null){
                        $lastSub->notify(new SubSoon());
                    }

                }
            }
        }
    }
}
