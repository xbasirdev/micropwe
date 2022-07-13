@component('mail::message')
<p>{{$message}}</p>
@component('mail::button', ['url' => $url])
Ver registro
@endcomponent
@endcomponent