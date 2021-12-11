<x-guest-layout>

    @section('title', "S'inscrire")

    <div class="auth-page">

        <div class="auth-form">

            <h1 class="h1 text-center">
                Créez un compte gratuitement!
            </h1>


            <x-jet-validation-errors class="error-status" />

            <form method="POST" action="{{route('register')}}" id="register-form" class="filter-form">
                
                @csrf

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="name" value="{{ __('Nom') }}" />
                    <x-jet-input id="name" placeholder="Ajouter votre nom compléte" type="text" name="name" :value="old('name')" required autofocus autocomplete="off" />
                </div>
    
                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" placeholder="Ajouter votre email" type="email" name="email" :value="old('email')" required autocomplete="off"/>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="tel" value="{{ __('Téléphone') }}" />
                    <x-jet-input id="tel" placeholder="Ajouter votre numéro de téléphone" type="tel" name="tel" :value="old('tel')" required autocomplete="off"/>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="cin" value="{{ __('CIN') }}" />
                    <x-jet-input id="cin" placeholder="Ajouter votre numéro de CIN" type="text" name="cin" :value="old('cin')" required autocomplete="off"/>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="agence" value="Nom d'agence" />
                    <x-jet-input id="agence" placeholder="Ajouter le nom de votre agence" type="text" name="agence" :value="old('agence')" required autocomplete="off"/>
                </div>
                
                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="password" value="{{ __('Mot de passe') }}" />
                    <x-jet-input id="password" placeholder="Créer un mot de passe" type="password" name="password" required autocomplete="new-password" />
                </div>
    
                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="password_confirmation" value="{{ __('Confirmer le mot de passe') }}" />
                    <x-jet-input id="password_confirmation" placeholder="Confermer le mot de passe" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="city" value="Ville" />
                    <x-jet-input v-on:keypress="autocomplete_c" v-model="city" id="ville" placeholder="Dans quelle ville se trouve votre agence" type="text" name="city" :value="old('city')" required autocomplete="off"/>
                    
                    <div class="autocomplete">
                        <span v-for = "(match, index) in match_c" :key="'c' + index" v-on:click = "setC(match)">@{{match}}</span>
                    </div>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="secteur" value="Secteur" />
                    <x-jet-input v-on:keypress="autocomplete_s" v-model="secteur" id="secteur" placeholder="Dans quelle secteur se trouve votre agence" type="text" name="secteur" :value="old('secteur')" required autocomplete="off" />
                    
                    <div class="autocomplete">
                        <span v-for = "(match, index) in match_s" :key="'s' + index" v-on:click = "setS(match)">@{{match}}</span>
                    </div>
                </div>

                <div class="filter-submit">
                    <x-jet-label class="labels wight-500 color-blue" value="{{ __('Séléctionner localisation de votre agence') }}" />
                    <input type="hidden" name="map_locale" id="map_locale">
                    <adm-admin-map @map="getLocation" />
                </div>
        
                <div class="filter-submit">

                    <div class="btnCnt">
                        <x-jet-button type="submit" class="buttonTxt">S'inscrire</x-jet-button>
                    </div>
                    
                    <x-jet-nav-link href="{{ route('login') }}" class="color-blue navLinks">
                        {{ __("Se connecter") }}
                    </x-jet-nav-link>

                    <p class="paragraph">
                        {!! __('En vous inscrivant, vous acceptez :terms_of_service et :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__("les conditions d'utilisation").'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__("la politique de confidentialité").'</a>',
                        ]) !!}
                    </p>
                    
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
