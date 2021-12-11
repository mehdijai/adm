<x-guest-layout>

    @section('title', 'Réinitialiser le mot de passe')

    <x-jet-authentication-card class="flex flex-column">
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Reset Password') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>

<x-guest-layout>

    @section('title', 'Réinitialiser le mot de passe')

    <div class="auth-page">

        <div class="auth-form">

            <span class="h1">
                Réinitialiser le mot de passe
            </span>

            <x-jet-validation-errors class="error-status" />

            <form method="POST" action="{{ route('password.update') }}" class="filter-form">
                @csrf
    
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
    
                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="email">Email</x-jet-label>
                    <x-jet-input id="email" name="email" type="email" placeholder="Entrez votre email address" :value="old('email', $request->email)" required autofocus></x-jet-input>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="password">Nouveau mot de passe</x-jet-label>
                    <x-jet-input id="password" name="password" type="password" placeholder="Entrez nouveau mot de passe" required autocomplete="new-password"></x-jet-input>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="password_confirmation">Confirmer mot de pass</x-jet-label>
                    <x-jet-input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirmer mot de passe" autocomplete="new-password"  required></x-jet-input>
                </div>

                <div class="filter-submit">
                    <x-jet-button type="submit" class="buttonTxt">Réinitialiser le mot de passe</x-jet-button>
                </div>
            </form>
        </div>
    </div>

</x-guest-layout>
