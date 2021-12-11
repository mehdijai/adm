<x-guest-layout>
    
    @section('keywords', $vehicule->marque()->get()[0]->marque . ", " . $vehicule->marque()->get()[0]->gamme . ", " . $vehicule->agence()->get()[0]->city()->get()[0]->city . " " . $vehicule->agence()->get()[0]->city()->get()[0]->secteur)
    @section('description', $vehicule->description)
    @section('title', $vehicule->marque()->get()[0]->marque . " " . $vehicule->marque()->get()[0]->gamme)
    @section('og-image', $vehicule->pics()->where('is_thumbnail', true)->get()[0]->image_path)

    <div class="vp_content">

        <div class="header">
            <div class="agence">
                <div class="img">
                    <img src="{{$vehicule->agence()->get()[0]->user()->get()[0]->profile_photo_url}}" alt="{{$vehicule->agence()->get()[0]->name}} {{$vehicule->agence()->get()[0]->city()->get()[0]->city}} {{$vehicule->agence()->get()[0]->city()->get()[0]->secteur}}">
                </div>
                <div class="data">
                    <span onclick="window.open('{{route('agence', ['id' => $vehicule->agence_id])}}', '_self')" class="labels color-red weight-700 cursor-pointer">{{ucfirst($vehicule->agence()->get()[0]->name)}}</span>
                    <span class="labels color-black">{{$vehicule->agence()->get()[0]->city()->get()[0]->city}} {{$vehicule->agence()->get()[0]->city()->get()[0]->secteur}}</span>
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
                <span class="paragraph">{{$vehicule->description}}</span>
                <span class="labels weight-700 color-red"><strong>Prix par jour: </strong>{{$vehicule->prix}} Dh</span>
                <span class="labels">{{$vehicule->type}}</span>
                <span class="labels"><strong>Véhicule: </strong>{{$vehicule->marque()->get()[0]->marque . " " . $vehicule->marque()->get()[0]->gamme}}</span>
                <span class="labels"><strong>Assurance: </strong>{{$vehicule->assurance}}</span>
                <span class="labels"><strong>Boite de vitesse: </strong>{{$vehicule->boite_de_vitesse}}</span>
                <span class="labels"><strong>Carburant: </strong>{{$vehicule->carb}}</span>
                <span class="labels"><strong>Options: </strong></span>
                <ul>
                    @foreach (json_decode($vehicule->options) as $option)
                        <li><span class="ml-4 labels">{{$option}}</span></li>
                    @endforeach
                    
                </ul>
                <a class="labels text-decoration-none color-blue" href="tel:{{$vehicule->agence()->get()[0]->tel}}"><strong>Téléphone: </strong>{{$vehicule->agence()->get()[0]->tel}}</a>
                <a class="labels text-decoration-none color-blue" href="email:{{$vehicule->agence()->get()[0]->user()->get('email')[0]->email}}"><strong>Email: </strong>{{$vehicule->agence()->get()[0]->user()->get('email')[0]->email}}</a>
                <div id="user-map">
                    <adm-user-map id="map" :lat="{{json_decode($vehicule->agence()->get()[0]->map_locale)->lat}}" :lng="{{json_decode($vehicule->agence()->get()[0]->map_locale)->long}}"></adm-user-map>
                </div>
            </div>

            <div class="gallery">
                @foreach ($vehicule->pics()->get() as $img)
                    <img src="{{$img->image_path}}" alt="{{$vehicule->marque()->get()[0]->marque . " " . $vehicule->marque()->get()[0]->gamme}}">
                @endforeach
            </div>
        </div>
    </div>

</x-guest-layout>