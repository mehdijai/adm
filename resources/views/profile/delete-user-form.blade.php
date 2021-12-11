<x-jet-action-section>
    <x-slot name="title">
        {{ __('Supprimer le compte') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Supprimer définitivement votre compte.') }}
    </x-slot>

    <x-slot name="content">

        @if (!$confirmingUserDeletion)
        <div>
            <div class="max-w-xl text-sm text-gray-600">
                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
            </div>
    
            <div class="mt-5">
                <x-jet-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                    {{ __('Supprimer le compte') }}
                </x-jet-button>
            </div>
        </div>

        <!-- Delete User Confirmation Modal -->
        
        @else
        <div>
            <div class="px-6 py-4">
                <div class="text-lg">
                    {{ __('Supprimer le compte') }}
                </div>
                
                <div class="mt-4">
                    {{ __('Êtes-vous sûr de vouloir supprimer votre compte ? Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.') }}
                    
                    <div class="mt-4 flex flex-column" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                        <x-jet-label class="labels wight-500 color-blue" value="{{ __('Mot de passe') }}" />
                        <x-jet-input type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Mot de passe') }}"
                        x-ref="password"
                        wire:model.defer="password"
                        wire:keydown.enter="deleteUser" />
                        
                        <x-jet-input-error for="password" class="mt-2" />
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-100 text-left">
                <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Annuler') }}
                </x-jet-secondary-button>
                
                <x-jet-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Supprimer le compte') }}
                </x-jet-button>
            </div>
        </div>
        @endif
        
    </x-slot>
</x-jet-action-section>
