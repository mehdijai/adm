<?php

namespace App\Actions\Fortify;

use App\Models\City;
use App\Models\User;
use App\Mail\newUser;
use App\Models\Agence;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'cin' => ['required', 'string', 'unique:users'],
            'tel' => ['required'],
            'map_locale' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'cin' => $input['cin'],
            'email' => $input['email'],
            'role_id' => 1,
            'password' => Hash::make($input['password']),
        ]);

        $cities_count = City::where('city', "LIKE", '%' . $input['city'] . '%')->where('secteur', "LIKE", "%" . $input['secteur'] . "%")->count();

        if($cities_count > 0){
            $city = City::where('city', "LIKE", '%' . $input['city'] . '%')->where('secteur', "LIKE", "%" . $input['secteur'] . "%")->first();
        }else{
            $city = City::create([
                'city' => $input['city'],
                'secteur' => $input['secteur'],
            ]);
        }

        $agence = Agence::create([
            'user_id' => $user->id,
            'city_id' => $city->id,
            'name' => $input['agence'],
            'tel' => $input['tel'],
            'map_locale' =>$input['map_locale']
        ]);

        Mail::to($user->email)->queue(new newUser());

        return $user;
    }
}
