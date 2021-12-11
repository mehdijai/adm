@component('mail::message')
<h1>Bonjour!</h1>
<p>
    Vous avez inscrit au plan {{$data['plan_name']}} pour une période de {{$data['periode']}} jours. {{$data['vehs_count']}} véhicules seront affecté par ce plan.
    <br>Mais, l'inscription restera inactive jusqu'à ce que nous recevions le reçu de paiement. Vous devez nous envoyer ce reçu par WhatsApp ou par Email
</p>
<hr>
@component('mail::button', ['url' => $data['wa']])
WhatsApp
@endcomponent
@component('mail::button', ['url' => $data['email']])
Email
@endcomponent
<hr>
<div align="center">
    <h4><strong><i>Merci d'utiliser notre application !</i></strong></h4>
    {{ config('app.name') }}
</div>
@endcomponent