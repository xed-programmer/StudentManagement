@component('mail::message')
{{-- If the html is not rendered unindentent all the codes here --}}
# Annoucement

{!! html_entity_decode($body) !!}

@component('mail::button', ['url' => url('/announcements')])
View More Announcements
@endcomponent

Thanks, <br>
{{ config('app.name') }}
@endcomponent