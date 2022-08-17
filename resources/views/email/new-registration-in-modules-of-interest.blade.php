@component('mail::message')
<p>{{$message}}</p>
@component('mail::button', ['url' => $url])
Visitar portal web
@endcomponent
@endcomponent