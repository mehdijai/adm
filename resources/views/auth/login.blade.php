<x-guest-layout>

    @section('title', 'Connecter')

    <div class="auth-page">

        <div class="auth-form">

            <span class="h1">
                Connectez-vous
            </span>

            <x-jet-validation-errors class="error-status" />

            <form method="POST" action="{{route('login')}}" class="filter-form">
                
                @csrf

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="email">Email</x-jet-label>
                    <x-jet-input name="email" type="email" placeholder="Entrez votre email address"></x-jet-input>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="password">Mot de passe</x-jet-label>
                    <x-jet-input name="password" type="password" placeholder="Entrez votre mot de passe"></x-jet-input>
                </div>
        
                <div class="filter-submit">
                    <x-jet-button type="submit" class="buttonTxt">Se connecter</x-jet-button>
        
                    <div class="extra">
                        <x-jet-nav-link href="{{ route('register') }}" class="color-blue navLinks">
                            {{ __("S'inscrire") }}
                        </x-jet-nav-link>
    
                        @if (Route::has('password.request'))
                            <x-jet-nav-link href="{{ route('password.request') }}" class="color-blue navLinks">
                                {{ __("Mot de passe oublié") }}
                            </x-jet-nav-link>
                        @endif
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

</x-guest-layout>
