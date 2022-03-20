@component('mail::message')
    # Annoucement

    @php
    echo $body;
    @endphp

    @component('mail::button', ['url' => url('/announcements')])
        View More Announcements
    @endcomponent

    Thanks, <br>
    {{ config('app.name') }}
@endcomponent
