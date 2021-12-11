<x-app-layout>

    @section('title', 'ADM Premium')

    
    <div class="contactSection bgc-white-lighter">

        <div class="title-txt">
            
            <span class="hero-headline text-center">ADM Premium</span>
            <span class="hero-subtitle text-center">Vous avez choisi le plan <i class="color-red">{{$plan->name}}</i> </span>
        
        </div>

        
        @if($errors->any())
            <div class="errors w-75">
                <span class="title color-red">{{$errors->first()}}</span>
            </div>
        @endif

        <div class="payementCnt">
            <form method="POST" action="{{route('premium.subscribe')}}" class="payement">
                @csrf
                
                <input type="hidden" name="plan_id" value="{{$plan->id}}">
                <div class="vehs-selection mb-5">
                    <input type="hidden" name="vehsids" id="vehs-ids">

                    <span class="title color-red">Séléctionner {{$plan->max_vehs}} vehicules qui vont étre affecter par ce plan. Il vous reste <span id="vehs-rest"></span></span>
                    <div class="hr"></div>

                    <div class="row vehicules bgc-white-lighter">
    
                        @foreach ($vehicules as $vehicule)
                    
                            <div align="center">
                                
                                <div class="car-card bgc-white" id="veh-{{$vehicule->id}}" onclick="selectVeh({{$vehicule->id}})">
                    
                                    <div class="cc-name" align="left">
                                        <span class="card-name color-black">{{ucfirst($vehicule->marque()->getEager()[0]->marque)}} {{ucfirst($vehicule->marque()->getEager()[0]->gamme)}}</span>
                                    </div>
                                
                                    <div class="cc-img">
                                        <img src="{{$vehicule->pics()->where('is_thumbnail', true)->get()[0]->image_path}}" alt="{{ucfirst($vehicule->marque()->getEager()[0]->marque)}} {{ucfirst($vehicule->marque()->getEager()[0]->gamme)}}">
                                    </div>
                                
                                    <div class="cc-footer">
                                
                                        <div class="cc-city">
                                            <span class="card-city color-black">{{ucfirst($vehicule->agence()->get()[0]->city()->getEager()[0]->city)}} {{ucfirst($vehicule->agence()->get()[0]->city()->getEager()[0]->secteur)}}</span>
                                        </div>
                                
                                        <div class="cc-price">
                                            <span class="card-price color-red">{{$vehicule->prix}} Dhs</span>
                                        </div>
                                
                                    </div>
                                </div>
                            </div>
                    
                        @endforeach
                        
                        @if (count($vehicules) == 0)
                            <div class="no-result text-center w-100">
                                <span class="h1">Vous n'avez pas encore des véhicules</span>
                                <x-jet-button onclick="window.open( '{{route('vehs.create')}}' , '_self')" class="buttonTxt mt-2">Ajouter des véhicules</x-jet-button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="period-range mb-5">
                    

                    <span class="title color-red">Séléctionner la période de votre plan. Ce offre va étre activé pendat cette periode <span id="period"></span></span>
                    <div class="hr mb-5"></div>

                    <div class="slider-container bgc-white-full flex items-center justify-center pt-5">
                        <input type="range" min="1" max="100" value="1" name="periode" class="slider" id="range-input" required>
                        <span id="range-value" class="title color-red ml-3"></span>
                    </div>

                    <div class="bgc-white-full flex items-center justify-center pb-3">
                        <span id="prix-total" class="title color-red block mt-4"></span>
                    </div>

                </div>

                <div class="paymentsInfo">
                    <span class="card-label color-red text-left">Paiement</span>
                    <div class="hr"></div>
                    <input type="hidden" name="plan_id" value="{{$plan->id}}">
                    <input type="hidden" name="montant" id="montant">
                    <p class="paragraph">
                        Votre demande sera enregistré après qu'on reçoive le paiement par versement bancaire.Vous devez nous envoyer le montant de plan (<span id="montant-total"></span> DH), et après que le paiement est arrivé on va activer votre demande. Sinon, on va vous contacter pour confirmer ce paiement.
                        Après que vous envoyer le paiement, Envoyez nous le reçu de paiement par: <br>
                        - Email: <a href="mailto:{{$contacts['email_premium']}}">{{$contacts['email_premium']}}</a> <br>
                        - WhatsApp: <a href="{{$contacts['email_premium']}}">{{$contacts['whatsapp_number']}}</a> <br>
                        <br><br>
                        Nom: {{$provider['name']}} <br>
                        Bank: {{$provider['bank']}} <br>
                        RIB: {{$provider['rib']}} <br>
                    </p>
                </div>

                <div class="flex items-center justify-left mt-4">

                    <x-jet-button type="submit" class="buttonTxt color-white">
                        {{ __('Confirmer') }}
                    </x-jet-button>

                    <x-jet-secondary-button type="button" class="buttonTxt color-white" onclick="window.open('{{route('premium.index')}}', '_self')">
                        {{ __('Annuler') }}
                    </x-jet-secondary-button>

                </div>
            </form>
        </div>

    </div>

    <script>
        let slider = document.getElementById("range-input");
        let output = document.getElementById("range-value");
        let prixTotal = document.getElementById("prix-total");
        let montantTotal = document.getElementById("montant-total");
        let montant = document.getElementById("montant");
        let period = document.getElementById("period");
        let vehsIds = document.getElementById('vehs-ids')
        let vehsrest = document.getElementById('vehs-rest')

        output.innerText = slider.value + " Jrs";
        period.innerText = slider.value + " Jrs";
        montantTotal.innerText = slider.value * {{$plan->price}}
        montant.value = slider.value * {{$plan->price}}
        prixTotal.innerText = "Montant total: " + (slider.value * {{$plan->price}}) + " Dhs";

        slider.oninput = function() {
            output.innerText = this.value + " Jrs";
            period.innerText = this.value + " Jrs";
            prixTotal.innerText = "Montant total: " + (slider.value * {{$plan->price}}) + " Dhs";
            montantTotal.innerText = (this.value * {{$plan->price}})
            montant.value = (this.value * {{$plan->price}})
        }

        let selectedVehsIds = []
        vehsrest.innerText = {{$plan->max_vehs}} - selectedVehsIds.length + " vehicules"

        function selectVeh(id){

            if(selectedVehsIds.indexOf(id) == -1){
                if(selectedVehsIds.length >= {{$plan->max_vehs}}){
                    alert('Vous avez passez le nombre maximal des vehicules allouées par ce plan! Désélectionnez autre vehicule si vous voulez choisir cette vehicule.')
                }else{
                    selectedVehsIds.push(id)
                    document.getElementById('veh-' + id).classList.add('selected')
                }
            }else{
                unselectVeh(id)
            }

            vehsrest.innerText = {{$plan->max_vehs}} - selectedVehsIds.length + " vehicules"
            saveInput()
        }

        function unselectVeh(id){
            let index = selectedVehsIds.indexOf(id)
            selectedVehsIds.splice(index, 1)
            document.getElementById('veh-' + id).classList.remove('selected')
        }

        function saveInput(){
            vehsIds.value = JSON.stringify(selectedVehsIds)
        }
    </script>

</x-app-layout>