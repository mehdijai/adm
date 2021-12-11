<x-app-layout>

    @section('title', 'Add Admin')

    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Add Admin</span>
        </div>

        <form action="{{route('admin.admins.store')}}" method="post" class="filter-form">

            @csrf

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="name" value="{{ __('Name') }}" />
                <x-jet-input placeholder="Admin Name" type="text" name="name" :value="old('name')" required autocomplete="off" />
                @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="email" value="{{ __('Email') }}" />
                <x-jet-input placeholder="Email" type="email" name="email" :value="old('email')" required autocomplete="off" />
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="cin" value="{{ __('CINE') }}" />
                <x-jet-input placeholder="N° CINE" type="text" name="cin" :value="old('cin')" required autocomplete="off" />
                @error('cin') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="filter-submit">
                <x-jet-button type="submit" class="buttonTxt">Save</x-jet-button>
            </div>

        </form> 
    
    </div>

</x-app-layout>