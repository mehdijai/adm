<x-guest-layout>
    
    @section('title', $agence->name)
    @section('keywords', $keywords)
    @section('description', $description)
    @section('og-image', $agence->user->profile_photo_url)

    <div class="vp_content">

        <div class="header">
            <div class="agence">
                <div class="img">
                    <img src="{{$agence->user->profile_photo_url}}" alt="{{$agence->name}} {{$agence->city->city}} {{$agence->city->secteur}}">
                </div>
                <div class="data">
                    <span class="labels color-black weight-700">{{ucfirst($agence->name)}}</span>
                    <span class="labels color-black">{{$agence->city->city}} {{$agence->city->secteur}}</span>
                </div>
            </div>
            <a id="close" href="#null" onclick="javascript:history.back();">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        <div class="main">
            <div class="side">
                <a class="labels text-decoration-none" href="tel:{{$agence->tel}}"><strong>Téléphone: </strong>{{$agence->tel}}</a>
                <a class="labels text-decoration-none" href="email:{{$agence->user->email}}"><strong>Email: </strong>{{$agence->user->email}}</a>
                <a class="labels text-decoration-none"><strong>Ville: </strong>{{$agence->city->city}} - {{$agence->city->secteur}}</a>
                <div id="user-map">
                    <adm-user-map id="map" :lat="{{json_decode($agence->map_locale)->lat}}" :lng="{{json_decode($agence->map_locale)->long}}"></adm-user-map>
                </div>
            </div>

            <div class="cars">
                <div class="row row-side vehicules bgc-white-lighter">
    
                    @foreach ($agence->vehicules as $car)
                
                        <div align="center">
                            
                            <a href="{{route('vehicule', $car->slug)}}" class="car-card bgc-white">
                
                                <div class="cc-name" align="left">
                                    <span class="card-name color-black">{{ucfirst($car->marque->marque . " " . $car->marque->gamme)}}</span>
                                </div>
                            
                                <div class="cc-img">
                                    <img src="{{$car->pics()->where('is_thumbnail', true)->get()[0]->image_path}}" alt="{{$car->marque->marque . " " . $car->marque->gamme}}">
                                </div>
                            
                                <div class="cc-footer">
                            
                                    <div class="cc-city">
                                        <span class="card-city color-black">{{ucfirst($agence->city->city)}} - {{ucfirst($agence->city->secteur)}}</span>
                                    </div>
                            
                                    <div class="cc-price">
                                        <span class="card-price color-red">{{$car->prix}} Dhs</span>
                                    </div>
                            
                                </div>
                            </a>
                        </div>
                
                    @endforeach
                
                </div>

                @if (count($agence->vehicules) == 0)
                    <div class="no-result text-center w-100">
                        <span class="h1">Désolé, Il n'y a pas encore des véhicules dans cette agence!</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-guest-layout>