<x-guest-layout>
    
    @section('title', 'Véhicules')
    @section('keywords', '')
    @section('description', '')
    @section('og-image', $vehicules->first()->pics()->where('is_thumbnail', true)->get()[0]->image_path)

    <div class="v-filter bgc-white" x-data="{open: false}">

        <div class="controllers">
            <span class="c-state labels weight-800">{{$vehicules->total()}} voitures</span>

            <x-jet-secondary-button x-show="open" name="HideFilterBtn" @click='open = false' class="c-action buttonTxt">Fermer</x-jet-secondary-button>

            <x-jet-button x-show="!open" name="ShowFilterBtn" id="ShowFilterBtn" @click='open = true' class="c-action buttonTxt">Filtrer</x-jet-button>

        </div>

        <form method="get" action="{{route('vehicules')}}" x-show='open' class="filter-form" >

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="VehiculeClass">Voiture / Minibus</x-jet-label>
                <select id="VehiculeClass" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="type">
                    <option value="" selected>Voiture ou Minibus?</option>

                    @foreach ($types as $type)
                        <option value="{{$type}}">{{ucfirst($type)}}</option>
                    @endforeach

                </select>
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="marque">La marque</x-jet-label>
                <select id="marque" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="marque">
                    <option value="" selected>Séléctionner la marque</option>

                    @foreach ($marques as $key => $marque)
                        <optgroup label={{$key}}">
                            @foreach ($marque as $gamme)
                                <option value="{{$gamme['id']}}">{{ucfirst($gamme['gamme'])}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                    
                </select>
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="ville">La ville</x-jet-label>
                <select id="ville" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="ville">
                    <option value="" selected>Séléctionner la ville</option>

                    @foreach ($cities as $key => $city)
                        <optgroup label="{{$key}}">
                            @foreach ($city as $secteur)
                                <option value="{{$secteur['id']}}">{{ucfirst($secteur['secteur'])}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                    
                </select>
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="assurance">Type d'assurance</x-jet-label>
                <select id="assurance" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="assurance">
                    <option value="" selected>Type d'assurance</option>
                    @foreach ($asss as $ass)
                        <option value="{{$ass}}">{{ucfirst($ass)}}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="carb">Type de carburant</x-jet-label>
                <select id="carb" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="carb">
                    <option value="" selected>Type de carburant</option>
                    @foreach ($carbs as $carb)
                        <option value="{{$carb}}">{{ucfirst($carb)}}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="bdv">Type de boite de vitesse</x-jet-label>
                <select id="bdv" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="bdv">
                    <option value="" selected>Type de boite de vitesse</option>
                    @foreach ($bdvs as $bdv)
                        <option value="{{$bdv}}">{{ucfirst($bdv)}}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="prixmin">Prix minimal</x-jet-label>
                <x-jet-input name="prix_min"  id="prixmin" type="number" placeholder="{{$prix_min}}"></x-jet-input>
            </div>

            <div class="filter-inputs">
                <x-jet-label class="labels wight-500 color-blue" for="prixmin">Prix maximal</x-jet-label>
                <x-jet-input name="prix_max" id="prixmax" type="number" placeholder="{{$prix_max}}"></x-jet-input>
            </div>

            <div class="filter-submit">
                <x-jet-button type="submit" class="buttonTxt">Filtrer</x-jet-button>

                <x-jet-nav-link href="{{ route('vehicules') }}" class="color-blue navLinks">
                    {{ __("Afficher tous") }}
                </x-jet-nav-link>
            </div>

        </form>

        
    </div>
        
    <div class="row vehicules bgc-white-lighter ">
    
        @foreach ($vehicules as $vehicule)
    
        
            <div align="center" @if($vehicule->vip) class="vp" @endif>
                
                <a href="{{route('vehicule', $vehicule->slug)}}" class="car-card bgc-white">
    
                    <div class="cc-name" align="left">
                        <span class="card-name color-black">{{ucfirst($vehicule->marque->marque . ' ' . $vehicule->marque->gamme)}}</span>
                    </div>
                
                    <div class="cc-img">
                        <img src="{{$vehicule->pics()->where('is_thumbnail', true)->get()[0]->image_path}}" alt="{{ucfirst($vehicule->marque->marque . ' ' . $vehicule->marque->gamme)}}">
                    </div>
                
                    <div class="cc-footer">
                
                        <div class="cc-city">
                            <span class="card-city color-black">{{ucfirst($vehicule->agence->city->city)}} - {{ucfirst($vehicule->agence->city->secteur)}}</span>
                        </div>
                
                        <div class="cc-price">
                            <span class="card-price color-red">{{$vehicule->prix}} Dhs</span>
                        </div>
                
                    </div>
                </a>
            </div>
    
        @endforeach
    
    </div>
    <div align="center" class="content-center">
        {{$vehicules->links()}}
    </div>

    @if (count($vehicules) == 0)
        <div class="no-result text-center w-100">
            <span class="h1">Désolé, Il n'y a aucune véhicule correspondants ces critères!</span>
        </div>
    @endif
</x-guest-layout>
