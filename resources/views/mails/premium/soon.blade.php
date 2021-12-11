@component('mail::message')
<h1>Bonjour!</h1>
<p>
    Votre plan {{$data['plan_name']}} va bientôt expirer! Il vous reste {{$data['remain']}} jours.<br>
    Vous pouvez trouver l'historique des inscription dans la page <a href="{{route('premium.index')}}"><strong>ADM Premium</strong></a> avec la facture.
</p>
<hr>
<div align="center">
    <h4><strong><i>Merci d'utiliser notre application !</i></strong></h4>
    {{ config('app.name') }}
</div>
@endcomponent