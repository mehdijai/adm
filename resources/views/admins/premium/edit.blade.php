<x-app-layout>

    @section('title', 'Edit plan')

    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Plan: {{$plan->name}}</span>
        </div>

        <form action="{{route('admin.plans.update')}}" method="post" class="filter-form">

            @csrf
            
            <input type="hidden" value="{{$plan->id}}" name="id">

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="name" value="{{ __('Name') }}" />
                <x-jet-input placeholder="Plan Name" type="text" name="name" value="{{old('name') ?? $plan->name}}" required autocomplete="off" />
                @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="price" value="{{ __('Price') }}" />
                <x-jet-input placeholder="Price per day" type="number" name="price" value="{{old('price') ?? $plan->price}}" required autocomplete="off" />
                @error('price') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="max_vehs" value="{{ __('Max N°') }}" />
                <x-jet-input placeholder="Maximum vehicules afected by the plan" type="number" name="max_vehs" value="{{old('max_vehs') ?? $plan->max_vehs}}" required autocomplete="off" />
                @error('max_vehs') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="filter-submit" id="offers" x-data='{new_offer: "", offers_json: {{ $plan->features }}, offers: {{ $plan->features }},
                addNewOffer(){
                    if(this.new_offer != ""){
                        this.offers.push(this.new_offer)
                        this.new_offer = ""
                        document.getElementById("offers-json").value = JSON.stringify(this.offers)
                        {{-- this.offers_json = JSON.stringify(this.offers) --}}
                    }

                },
                deleteOffer(offer){
                    if(offer != ""){
                        let index = this.offers.indexOf(offer)
                        if (index > -1) {
                            this.offers.splice(index, 1);
                            document.getElementById("offers-json").value = JSON.stringify(this.offers)
                        }
                        {{-- this.offers_json = JSON.stringify(this.offers) --}}
                    }
                },
            }'>
                <span class="title wight-500 color-red" value="{{ __('Offres') }}" />
                <input type="hidden" id="offers-json" name="features" value="{{ $plan->features }}">
                <div class="offers-form">
                    <x-jet-label class="labels wight-500 color-blue" for="new-offer" value="{{ __('Add a new one') }}" />
                    <div class="flex">
                        <x-jet-input x-model="new_offer" placeholder="Add new offer" type="text" name="new-offer" autocomplete="off" />
                        <span @click="addNewOffer">Add <x-heroicon-s-plus class="icon ml-1"/></span>
                    </div>
                    <div class="data">
                        <template x-for="offer in offers">
                            <span class="item"> <span x-text="offer"></span> <x-heroicon-s-x-circle @click="deleteOffer(offer)" class="icon ml-1 color-danger hover"/> </span>
                        </template>
                    </div>
                </div>
            </div>

            <div class="filter-submit">
                <x-jet-button type="submit" class="buttonTxt">Save</x-jet-button>
                
            </div>

        </form> 
    
    </div>

</x-app-layout>