@component('mail::message')
<h1>Message sent from support form</h1>
@component('mail::panel')
<h3>Name</h3><br>
<span>{{$from_name}}</span>
@endcomponent
<hr>
@component('mail::panel')
<h3>Email</h3><br>
<span>{{$from_email}}</span>
@endcomponent
<hr>
@component('mail::panel')
<h3>Subject</h3><br>
<span>{{$subject}}</span>
@endcomponent
<hr>
@component('mail::panel')
<h3>Message</h3><br>
<span>{{$message}}</span>
@endcomponent

{{ config('app.name') }}
@endcomponent