@component('mail::message')
# {{ __('Support Message from') }} [{{$name}}]({{$email}})

{{$message}}
@endcomponent