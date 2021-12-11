<?php

namespace App\Actions\Jetstream;

use App\Models\Agence;
use App\Models\Vehicule;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\User\deletedAccount;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {

        if($user->role_id == 1){

            // * Delete subscriptions

            // * get all this user's subscriptions
            $subs = $user->subscriptions()->getEager();

            if(! empty($subs)){
                foreach ($subs as $sub) {
                    try{

                        // * get vehicules ids to update ranking score
                        $ids = json_decode($sub->vehicules_ids);
                        $sub->delete();
            
                        // * update vehicul ranking score
                        Vehicule::updateScore($ids, $sub);
            
            
                    }catch (\Exception $exception){
                        Log::error($exception->getMessage());
                    }
                }
            }

            // * Delete vehicules
            
            $vehicules = $user->agence()->first()->vehicules()->getEager();

            // * Delete vehicule

            if(! empty($vehicules)){

                foreach($vehicules as $vehicule){

                    $marques = $vehicule->marque()->getEager()[0];
            
                    // * remove pics from database
                    $pics = $vehicule->pics()->delete();

                    // * delete vehicule
                    $vehicule->delete();


                    // * check if the marque is owned by another vehicule

                    $vehicules_with_the_same_marque = Vehicule::where('marque_id', $marques->id)->count();

                    if($vehicules_with_the_same_marque == 0){
                        $marques->delete();
                    }
                }

            }

            // * delete agence

            // * get the city instance
            $city = $user->agence()->first()->city()->first();

            $user->agence()->first()->delete();

            // * Delete city if not useable anymore

            $agence_with_the_same_city = Agence::where('city_id', $city->id)->count();

            if($agence_with_the_same_city == 0){
                // * delete this city
                $city->delete();
            }

            $user->deletePics();
            $user->notify(new deletedAccount());
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            
            $user->delete();

        }else{

            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();
        }

    }
}
