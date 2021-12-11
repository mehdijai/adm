@component('mail::message')
<h1>Bonjour M. {{$user->name}}!</h1>
<h3><i>Vous nous manquerez!</i></h3>
<p>
    vous avez supprimé votre compte de notre plateforme. Nous espérons que vous avez apprécié le processus d'ADM, sinon contactez-nous et partagez votre opinion avec nous. <br>
    Notre mission est d'aider votre business, et nous pouvons le faire avec votre aide.
</p>
<hr>
<div align="center">
    <h4><strong><i>Merci d'utiliser notre application !</i></strong></h4>
    {{ config('app.name') }}
</div>
@endcomponent