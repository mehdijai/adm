@component('mail::message')
<h1>Bonjour!</h1>
<p>
    Félicitations ! Votre compte a été créé avec succès. Vous pouvez maintenant ajouter un nombre illimité de véhicules.
</p>
@component('mail::button', ['url' => '/dashboard'])
accéder à mon profile
@endcomponent
<hr>
<div align="center">
    <h4><strong><i>Merci d'utiliser notre application !</i></strong></h4>
    {{ config('app.name') }}
</div>
@endcomponent