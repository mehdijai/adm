<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Information de profile') }}
    </x-slot>

    <x-slot name="description">
        {{ __("Mettez à jour les informations du profil et l'adresse électronique de votre compte.") }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4 m-0">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" width="100" height="100" style="object-fit: cover" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Sélectionner une nouvelle photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Supprimer la photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif
        
        {{-- Name --}}
        <div class="flex flex-column mt-5">
            <x-jet-label class="labels wight-500 color-blue" for="name" value="{{ __('Nom') }}" />
            <x-jet-input id="name" placeholder="Votre nom" type="text" name="name" autocomplete="name" wire:model.defer="state.name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="flex flex-column mt-2">
            <x-jet-label class="labels wight-500 color-blue" for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" placeholder="Votre email" type="email" name="email" autocomplete="email" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        {{-- CIN --}}
        <div class="flex flex-column mt-5">
            <x-jet-label class="labels wight-500 color-blue" for="cin" value="{{ __('CIN') }}" />
            <x-jet-input id="cin" placeholder="Votre CIN" type="text" name="cin" autocomplete="cin" wire:model.defer="state.cin" />
            <x-jet-input-error for="cin" class="mt-2" />
        </div>

        @if (auth()->user()->role_id == 1)
            
        <h3 class="text-lg font-medium text-gray-900 mt-5 mb-3">{{__("Information d'Agence")}}</h3>

        {{-- Agence Name --}}
        <div class="flex flex-column mt-5">
            <x-jet-label class="labels wight-500 color-blue" for="agence" value="Nom d'agence" />
            <x-jet-input id="agence" placeholder="Votre nom d'agence" type="text" name="agence" autocomplete="agence" wire:model.defer="state.agence" />
            <x-jet-input-error for="agence" class="mt-2" />
        </div>

        {{-- Agence Tel --}}
        <div class="flex flex-column mt-5">
            <x-jet-label class="labels wight-500 color-blue" for="tel" value="{{ __('Téléphone') }}" />
            <x-jet-input id="tel" placeholder="Téléphone d'agence" type="tel" name="tel" autocomplete="tel" wire:model.defer="state.tel" />
            <x-jet-input-error for="tel" class="mt-2" />
        </div>

        
        {{-- City --}}
        <div class="flex flex-column mt-5">
            <x-jet-label class="labels wight-500 color-blue" for="city" value="Ville" />
            <x-jet-input v-on:keypress="autocomplete_c" v-model="city" id="ville" wire:model.defer="state.city" placeholder="Dans quelle ville se trouve votre agence" type="text" name="ville" autocomplete="off" />
            <x-jet-input-error for="city" class="mt-2" />
        </div>
        
        {{-- Secteur --}}
        <div class="flex flex-column mt-5">
            <x-jet-label class="labels wight-500 color-blue" for="secteur" value="Secteur" />
            <x-jet-input v-on:keypress="autocomplete_s" v-model="secteur" id="secteur" wire:model.defer="state.secteur" placeholder="Dans quelle secteur se trouve votre agence" type="text" name="secteur" autocomplete="off" />
            <x-jet-input-error for="secteur" class="mt-2" />
        </div>

        {{-- MAP --}}
        <div class="flex flex-column mt-5" id="admin-map">
            <x-jet-label class="labels wight-500 color-blue" value="Localisation" />
            <input type="hidden" name="map_locale" id="map_locale" wire:model="state.map_locale">
            <adm-admin-map @map="getLocation" wire:ignore :edit="true"/>
        </div>

        @endif

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Enregistré') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Enregistrer') }}
        </x-jet-button>
    </x-slot>

    
</x-jet-form-section>