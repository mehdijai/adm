<x-guest-layout>

    @section('title', 'Mot de passe oublié')

    <div class="auth-page">

        <div class="auth-form items-center">

            <span class="h1 w-50 text-center">
                Réinitialiser le mot de passe
            </span>

            <span class="paragraph mt-2 w-50">
                Vous avez oublié votre mot de passe ? Aucun problème. Il suffit de nous communiquer votre email et nous vous enverrons un lien de réinitialisation du mot de passe qui vous permettra d'en choisir un nouveau.
            </span>

            <x-jet-validation-errors class="error-status w-50" />

            <form method="POST" action="{{ route('password.email') }}" class="filter-form w-50">
                @csrf

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="email">Email</x-jet-label>
                    <x-jet-input id="email" name="email" type="email" placeholder="Entrez votre email address" :value="old('email')" required autofocus></x-jet-input>
                </div>

                <div class="filter-submit">
                    <x-jet-button type="submit" class="buttonTxt">Envoyer le lien de réinitialisation</x-jet-button>                    
                </div>

            </form>
        </div>
    </div>

</x-guest-layout>

