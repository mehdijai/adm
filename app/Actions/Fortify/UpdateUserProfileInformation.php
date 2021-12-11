<?php

namespace App\Actions\Fortify;

use App\Models\City;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'cin' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if(Auth::user()->role_id == 1){
            Validator::make($input, [
                'agence' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'secteur' => ['required', 'string', 'max:255'],
                'map_locale' => ['required', 'string', 'max:255'],
                'tel' => ['required', 'string', 'max:255'],
            ])->validateWithBag('updateProfileInformation');
        }

        

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'cin' => $input['cin'],
            ])->save();

            if(Auth::user()->role_id == 1){
                $agence = $user->agence()->getEager()[0];
                
                /* City */
                $cities_count = City::where('city', "LIKE", '%' . $input['city'] . '%')->where('secteur', "LIKE", "%" . $input['secteur'] . "%")->count();
                $db_city = null;
    
                if($cities_count > 0){
                    $db_city = City::where('city', "LIKE", '%' . $input['city'] . '%')->where('secteur', "LIKE", "%" . $input['secteur'] . "%")->first();
                }else{
                    $db_city = City::create([
                        'city' => $input['city'],
                        'secteur' => $input['secteur'],
                    ]);
                }
    
                $agence->forceFill([
                    'name' => $input['agence'],
                    'tel' => $input['tel'],
                    'city_id' => $db_city->id,
                    'map_locale' => $input['map_locale'],
                ])->save();
            }

        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
