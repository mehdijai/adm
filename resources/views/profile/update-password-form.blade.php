<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Mettre à jour le mot de passe') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.') }}
    </x-slot>

    <x-slot name="form">
        <div class="flex flex-column mt-3">
            <x-jet-label class="labels wight-500 color-blue" for="current_password" value="{{ __('Mot de passe actuel') }}" />
            <x-jet-input id="current_password" placeholder="Mot de passe actuel" type="password" name="current_password" autocomplete="current_password" wire:model.defer="state.current_password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="flex flex-column mt-3">
            <x-jet-label class="labels wight-500 color-blue" for="password" value="{{ __('Nouveau mot de passe') }}" />
            <x-jet-input id="password" placeholder="Nouveau mot de passe" type="password" name="password" autocomplete="password" wire:model.defer="state.password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="flex flex-column mt-3">
            <x-jet-label class="labels wight-500 color-blue" for="password_confirmation" value="{{ __('Confirmer mot de passe') }}" />
            <x-jet-input id="password_confirmation" placeholder="Confirmer mot de passe" type="password" name="password_confirmation" autocomplete="password_confirmation" wire:model.defer="state.password_confirmation" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Enregistré') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Enregistrer') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
