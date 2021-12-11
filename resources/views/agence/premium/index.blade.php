<x-app-layout>

    @section('title', 'ADM Premium')

    @if($status == 'free_mode' || $status == 'expired_mode')
        <div class="contactSection mb-5 bgc-white-lighter sm:pt-0">

            <div class="title-txt">
                
                <span class="hero-headline text-center">ADM Premium</span>

                @if($status == 'free_mode')
                    <span class="hero-subtitle text-center">Achetez un plan d'ADM Premium pour que vos annonce s'apparait au premières résultats.</span>
                @else
                    <span class="hero-subtitle text-center">Votre plan a été expiré, acheter une autre plan d'ADM Premium pour que vos annonce s'apparait au premières résultats.</span>
                @endif
            
            </div>

            <div class="plans">
            @foreach ($plans as $plan)
                <div class="plan">
                    <span class="card-label color-red">
                        {{$plan->name}}
                    </span>
                    <div class="hr"></div>
                    <span class="paragraph text-center">
                        Prix par jour
                    </span>
                    <span class="card-label color-red">
                        {{$plan->price}} Dhs
                    </span>
                    <span class="paragraph text-center">
                        Nombre de véhicules affectées
                    </span>
                    <span class="card-label color-red">
                        {{$plan->max_vehs}}
                    </span>
                    <span class="paragraph text-center">
                        Offres
                    </span>
                    <span class="paragraph color-red text-center m-0">
                        <ul class="list-none m-0 p-0">
                            @foreach (json_decode($plan->features) as $feature)
                            <li>{{$feature}}</li>
                            @endforeach
                        </ul>
                    </span>
                    <x-jet-button class="buttonTxt hover color-white" onclick="window.open('premium/{{ $plan->id }}', '_self')">
                        {{ __('Choisire') }}
                    </x-jet-button>
                </div>
            @endforeach
            </div>
        </div>
    @endif

    @if($status == 'non_active_mode')
        <div class="contactSection mb-5 bgc-white-lighter sm:pt-0">

            <div class="title-txt">
                
                <span class="hero-headline text-center">ADM Premium - En attendant...</span>
                <span class="hero-subtitle text-center">votre plan <strong class="color-red">{{$subscription->plan()->getEager()[0]->name}}</strong> sera activé après confirmation du paiement.</span>
            
            </div>

            <div class="bgc-white-full p-4 rounded-lg shadow-sm">
                <p class="paragraph color-black">Envoyez nous le reçu de paiement par WhatsApp ou par email pour le confirmer et activer votre plan</p>
                <p class="paragraph color-black">le montant totale que vous devez payez est: {{$subscription->montant}} Dhs</p>
                <span class="labels color-blue"><strong>WhatApp: </strong>{{$contact_data['whatsapp_number']}}</span><br>
                <span class="labels color-blue"><strong>Email: </strong>{{$contact_data['email_premium']}}</span>
            </div>

        </div>
    @endif

    @if($status == 'active_mode' || $status == 'soon_mode')
        <div class="contactSection mb-5 bgc-white-lighter sm:pt-0">

            <div class="title-txt">
                
                <span class="hero-headline text-center">ADM Premium - {{$subscription->plan()->get()[0]->name}}</span>
                @if($status == 'active_mode')
                    <span class="hero-subtitle text-center">votre plan est activé!</span>
                @else
                    <span class="hero-subtitle text-center">votre plan va étre expiré dans <strong class="color-red">{{$expiration}} jrs!</strong></span>
                @endif
            </div>

            <div class="bgc-white-full p-4 rounded-lg shadow-sm">
                <p class="paragraph color-black">Ce plan va éxpiré au {{$expiration_date}}</p>
                <p class="paragraph color-black">Si vous avez recontrer des problèmes <a class="color-blue weight-700" href="{{route('support')}}">Contactez-nous</a></p>
            </div>

        </div>
    @endif

</x-app-layout>