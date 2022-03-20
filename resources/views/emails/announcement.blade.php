@component('mail::message')
    # Annoucement

    {!! html_entity_decode($body) !!}

    @component('mail::button', ['url' => url('/announcements')])
        View More Announcements
    @endcomponent

    Thanks, <br>
    {{-- {{ config('app.name') }} --}}
    School
@endcomponent
